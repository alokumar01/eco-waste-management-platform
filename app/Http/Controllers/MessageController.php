<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the chat with a specific user.
     */
    public function show(User $receiver, Request $request)
    {
        $bookingId = $request->query('booking_id');
        $user = Auth::user();

        // Get messages between auth user and receiver
        $messagesQuery = Message::with(['sender', 'receiver'])
            ->where(function ($query) use ($user, $receiver) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($query) use ($user, $receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('receiver_id', $user->id);
            });

        if ($bookingId) {
            $messagesQuery->where('booking_id', $bookingId);
        }

        $messages = $messagesQuery->orderBy('created_at', 'asc')->get();

        // Mark recipient's messages as read
        Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $booking = $bookingId ? Booking::find($bookingId) : null;

        return view('messages.show', compact('messages', 'receiver', 'booking'));
    }

    /**
     * Store a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'booking_id' => $request->booking_id,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', 'Message sent.');
    }

    /**
     * List all conversations for the user.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Simplified way to get conversation partners
        $sentTo = Message::where('sender_id', $user->id)->pluck('receiver_id');
        $receivedFrom = Message::where('receiver_id', $user->id)->pluck('sender_id');
        
        $userIds = $sentTo->merge($receivedFrom)->unique()->filter(fn($id) => $id != $user->id);
        
        $conversations = User::whereIn('id', $userIds)->get()->map(function($otherUser) use ($user) {
            $lastMessage = Message::where(function($q) use ($user, $otherUser) {
                $q->where('sender_id', $user->id)->where('receiver_id', $otherUser->id);
            })->orWhere(function($q) use ($user, $otherUser) {
                $q->where('sender_id', $otherUser->id)->where('receiver_id', $user->id);
            })->latest()->first();
            
            $otherUser->lastMessage = $lastMessage;
            return $otherUser;
        })->sortByDesc(function($u) {
            return $u->lastMessage ? $u->lastMessage->created_at : now()->subYears(1);
        });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Get new messages for polling (AJAX).
     */
    public function getMessages(User $receiver, Request $request)
    {
        $user = Auth::user();
        $lastMessageId = $request->query('last_id', 0);

        $messages = Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })
            ->orWhere(function ($query) use ($user, $receiver) {
                $query->where('sender_id', $receiver->id)
                    ->where('receiver_id', $user->id);
            })
            ->where('id', '>', $lastMessageId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark received messages as read
        Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'read_at' => $msg->read_at,
                    'created_at' => $msg->created_at->format('h:i A'),
                    'is_sent_by_auth' => $msg->sender_id === $user->id,
                ];
            }),
        ]);
    }
}