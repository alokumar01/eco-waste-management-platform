<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total platform revenue (completed transactions)
        $totalRevenue = Transaction::where('status', 'completed')->sum('amount');
        
        // Total bookings
        $totalBookings = Booking::count();
        
        // Total services
        $totalServices = Service::count();
        
        // Total users (excluding admins)
        $totalUsers = User::whereIn('role', ['user', 'provider'])->count();
        
        // Providers (existing logic)
        $providers = User::where('role', 'provider')->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'totalServices',
            'totalUsers',
            'providers'
        ));
    }
}
