<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Auth::user()->reviews()->with('user')->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user and is completed
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        return view('reviews.create', compact('booking'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user and is completed
        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'provider_id' => $booking->provider_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('bookings.my')->with('success', 'Review submitted successfully.');
    }
}
