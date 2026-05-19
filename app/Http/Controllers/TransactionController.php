<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provider = Auth::user();
        $providerBookingIds = $provider->providerBookings()->pluck('id');

        $transactions = Transaction::whereIn('booking_id', $providerBookingIds)
            ->latest()
            ->paginate(10);

        $totalEarnings = Transaction::whereIn('booking_id', $providerBookingIds)
            ->where('status', 'paid_out')
            ->sum('amount');

        $pendingPayout = Transaction::whereIn('booking_id', $providerBookingIds)
            ->where('status', 'pending')
            ->sum('amount');

        return view('earnings.index', compact('transactions', 'totalEarnings', 'pendingPayout'));
    }
}