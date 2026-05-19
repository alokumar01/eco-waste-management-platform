<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Review;

class ProviderDashboardController extends Controller
{
    public function index()
    {
        $provider = Auth::user();
        $services = $provider->services;
        $bookings = $provider->providerBookings()->with('service')->get();
        $transactions = Transaction::whereIn('booking_id', $bookings->pluck('id'))->get();

        $totalServices = $services->count();
        $totalBookings = $bookings->count();
        
        // Correctly calculate total earnings
        $bookingIds = $bookings->pluck('id');
        $totalEarnings = Transaction::whereIn('booking_id', $bookingIds)
                                    ->where('status', 'completed')
                                    ->sum('amount');
        
        $reviews = Review::whereIn('booking_id', $bookings->pluck('id'));
        $avgRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
        $totalReviews = $reviews->count();

        $upcomingBookings = $bookings->whereIn('status', ['confirmed', 'pending'])
                                     ->where('scheduled_at', '>=', now()->startOfDay())
                                     ->sortBy('scheduled_at')
                                     ->take(5);
        $recentServices = $services->sortByDesc('created_at')->take(4);

        // Prepare data for earnings chart for the last 30 days
        $chartLabels = [];
        $chartData = [];
        $endDate = now()->endOfDay();
        $startDate = now()->subDays(29)->startOfDay();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $chartLabels[] = $date->format('M d');
            $dailyTotal = Transaction::whereIn('booking_id', $bookingIds)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('amount');
            $chartData[] = $dailyTotal;
        }

        // Dynamic Profile completion logic
        $completedSteps = 0;
        $totalSteps = 5;

        // Step 1: Basic Info (Name, Email, Phone number)
        $hasBasicInfo = !empty($provider->name) && !empty($provider->email) && !empty($provider->phone_number);
        if ($hasBasicInfo) $completedSteps++;

        // Step 2: Profile Picture
        $hasProfilePic = !empty($provider->profile_picture);
        if ($hasProfilePic) $completedSteps++;

        // Step 3: Business Details (Business Name, Bio)
        $hasBusinessDetails = !empty($provider->business_name) && !empty($provider->bio);
        if ($hasBusinessDetails) $completedSteps++;

        // Step 4: Service Location (Business address, City, State, Pincode)
        $hasServiceLocation = !empty($provider->business_address) && !empty($provider->city) && !empty($provider->state) && !empty($provider->pincode);
        if ($hasServiceLocation) $completedSteps++;

        // Step 5: Bank Details (Considered complete if verified or completed other steps)
        $hasBankDetails = (bool)$provider->is_verified;
        if ($hasBankDetails) $completedSteps++;

        $profileCompletion = round(($completedSteps / $totalSteps) * 100);

        return view('provider-dashboard', compact(
            'provider',
            'totalServices',
            'totalBookings',
            'totalEarnings',
            'avgRating',
            'totalReviews',
            'upcomingBookings',
            'recentServices',
            'profileCompletion',
            'hasBasicInfo',
            'hasProfilePic',
            'hasBusinessDetails',
            'hasServiceLocation',
            'hasBankDetails',
            'bookings',
            'chartLabels',
            'chartData'
        ));
    }
}
