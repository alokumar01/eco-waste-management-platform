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
        return view('bookings.show', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Add authorization check if needed
        // $this->authorize('update', $booking);

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            // Create a transaction
            Transaction::create([
                'booking_id' => $booking->id,
                'amount' => $booking->service->price, // Assuming the price is on the service model
                'status' => 'completed', // Or 'completed' if payment is instant
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
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

