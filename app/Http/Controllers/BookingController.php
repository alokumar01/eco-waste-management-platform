<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Auth::user()->providerBookings()->with(['customer', 'service'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

    public function payment(Request $request)
    {
        if ($request->has('booking_id')) {
            $booking = Booking::findOrFail($request->booking_id);
            if ($booking->customer_id !== Auth::id()) {
                abort(403, 'Unauthorized.');
            }
            return view('bookings.payment', [
                'booking' => $booking,
                'service' => $booking->service,
            ]);
        }

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date',
            'instructions' => 'nullable|string|max:200',
        ]);

        $service = Service::findOrFail($request->service_id);
        
        return view('bookings.payment', [
            'service' => $service,
            'scheduled_at' => $request->scheduled_at,
            'instructions' => $request->instructions,
        ]);
    }

    /**
     * Process payment for an accepted booking.
     */
    public function pay(Request $request, Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'accepted') {
            return redirect()->route('bookings.my')->with('error', 'This booking cannot be paid for at this time.');
        }

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        Transaction::create([
            'booking_id' => $booking->id,
            'amount' => $booking->price,
            'status' => 'completed',
        ]);

        $booking->provider->notify(new \App\Notifications\BookingStatusChangedNotification($booking, 'accepted', 'confirmed'));

        return redirect()->route('bookings.my')->with('success', 'Payment processed successfully! Your booking is now confirmed.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date',
        ]);

        $service = Service::findOrFail($request->service_id);

        Booking::create([
            'customer_id' => Auth::id(),
            'provider_id' => $service->user_id,
            'service_id' => $service->id,
            'scheduled_at' => $request->scheduled_at,
            'price' => $service->price,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.my')->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $user = Auth::user();
        if ($user->id === $booking->provider_id) {
            return redirect()->route('bookings.index')->with('highlight_booking', $booking->id);
        } elseif ($user->id === $booking->customer_id) {
            return redirect()->route('bookings.my')->with('highlight_booking', $booking->id);
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Check authorization (ensure authenticated user is the provider)
        if ($booking->provider_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:accepted,confirmed,completed,cancelled',
            'waste_amount' => 'required_if:status,completed|numeric|min:0',
        ]);

        $oldStatus = $booking->status;
        $statusInput = $request->status;

        if ($statusInput === 'completed') {
            $booking->update([
                'status' => 'completed',
                'waste_amount' => $request->waste_amount,
            ]);
        } else {
            $booking->update(['status' => $statusInput]);
        }

        if ($statusInput === 'completed') {
            // Create a transaction if it doesn't exist
            if (!$booking->transaction) {
                Transaction::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->price,
                    'status' => 'completed',
                ]);
            }
        }

        if ($statusInput === 'cancelled') {
            // Process refund if already paid
            if ($booking->payment_status === 'paid') {
                $booking->payment_status = 'refunded';
                $booking->save();

                if ($booking->transaction) {
                    $booking->transaction->update(['status' => 'refunded']);
                }

                // Notify customer of refund
                $booking->customer->notify(new \App\Notifications\BookingRefundedNotification($booking, $booking->price));
            }

            \App\Models\Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $booking->customer_id,
                'booking_id' => $booking->id,
                'message' => "The booking has been declined/cancelled.",
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Cancel/refund if paid
        if ($booking->status !== 'cancelled' && $booking->status !== 'completed') {
            if ($booking->payment_status === 'paid') {
                $booking->payment_status = 'refunded';
                $booking->save();

                if ($booking->transaction) {
                    $booking->transaction->update(['status' => 'refunded']);
                }

                $booking->customer->notify(new \App\Notifications\BookingRefundedNotification($booking, $booking->price));
            }
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    /**
     * Display a listing of the customer's bookings.
     */
    public function myBookings()
    {
        $bookings = Auth::user()->customerBookings()->with(['provider', 'service'])->latest()->get();
        return view('bookings.my-bookings', compact('bookings'));
    }
}

