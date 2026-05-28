<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Review;
use App\Models\BlogPost;
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

        // Verified providers count
        $verifiedProvidersCount = User::where('role', 'provider')->where('is_verified', true)->count();

        // Average rating across the platform
        $averageRating = Review::avg('rating') ?: 0;
        
        // Providers pending verification (profile completed but not verified)
        $pendingProviders = User::where('role', 'provider')
            ->where('is_verified', false)
            ->latest()
            ->get();

        // Latest Services
        $latestServices = Service::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Blog Posts Overview
        $blogPosts = BlogPost::with('author')
            ->latest()
            ->take(5)
            ->get();

        // Recent Bookings
        $recentBookings = Booking::with(['customer', 'provider', 'service'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Reviews
        $recentReviews = Review::with(['user', 'provider'])
            ->latest()
            ->take(5)
            ->get();

        // Trend calculations (This month vs Last month)
        $thisMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        // Helper closures for clean code
        $getTrend = function($thisMonthVal, $lastMonthVal) {
            if ($lastMonthVal > 0) {
                $pct = (($thisMonthVal - $lastMonthVal) / $lastMonthVal) * 100;
                return [
                    'label' => sprintf('%s%.1f%%', $pct >= 0 ? '+' : '', $pct),
                    'dir' => $pct > 0 ? 'up' : ($pct < 0 ? 'down' : 'neutral')
                ];
            }
            if ($thisMonthVal > 0) {
                return [
                    'label' => '+' . $thisMonthVal . ' new',
                    'dir' => 'up'
                ];
            }
            return [
                'label' => '0% change',
                'dir' => 'neutral'
            ];
        };

        // Users Trend
        $thisMonthUsers = User::whereIn('role', ['user', 'provider'])->where('created_at', '>=', $thisMonthStart)->count();
        $lastMonthUsers = User::whereIn('role', ['user', 'provider'])->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $usersTrend = $getTrend($thisMonthUsers, $lastMonthUsers);

        // Verified Trend
        $thisMonthVerified = User::where('role', 'provider')->where('is_verified', true)->where('created_at', '>=', $thisMonthStart)->count();
        $lastMonthVerified = User::where('role', 'provider')->where('is_verified', true)->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $verifiedTrend = $getTrend($thisMonthVerified, $lastMonthVerified);

        // Services Trend
        $thisMonthServices = Service::where('created_at', '>=', $thisMonthStart)->count();
        $lastMonthServices = Service::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $servicesTrend = $getTrend($thisMonthServices, $lastMonthServices);

        // Bookings Trend
        $thisMonthBookings = Booking::where('created_at', '>=', $thisMonthStart)->count();
        $lastMonthBookings = Booking::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $bookingsTrend = $getTrend($thisMonthBookings, $lastMonthBookings);

        // Revenue Trend
        $thisMonthRevenue = Transaction::where('status', 'completed')->where('created_at', '>=', $thisMonthStart)->sum('amount');
        $lastMonthRevenue = Transaction::where('status', 'completed')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('amount');
        $revenueTrend = $getTrend($thisMonthRevenue, $lastMonthRevenue);

        // Rating Trend
        $thisMonthRating = Review::where('created_at', '>=', $thisMonthStart)->avg('rating') ?: 0;
        $lastMonthRating = Review::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->avg('rating') ?: 0;
        $ratingDiff = $thisMonthRating - $lastMonthRating;
        $ratingTrend = [
            'label' => sprintf('%s%.1f', $ratingDiff >= 0 ? '+' : '', $ratingDiff),
            'dir' => $ratingDiff > 0 ? 'up' : ($ratingDiff < 0 ? 'down' : 'neutral')
        ];

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'totalServices',
            'totalUsers',
            'verifiedProvidersCount',
            'averageRating',
            'pendingProviders',
            'latestServices',
            'blogPosts',
            'recentBookings',
            'recentReviews',
            'usersTrend',
            'verifiedTrend',
            'servicesTrend',
            'bookingsTrend',
            'revenueTrend',
            'ratingTrend'
        ));
    }

    public function providers()
    {
        $providers = User::where('role', 'provider')
            ->orderBy('is_verified', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.providers', compact('providers'));
    }

    public function reviews()
    {
        $reviews = Review::with(['user', 'provider'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }

    public function allArticles()
    {
        $articles = BlogPost::with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all-articles', compact('articles'));
    }

    public function toggleArticleStatus(BlogPost $blogPost)
    {
        $newStatus = $blogPost->status === 'published' ? 'draft' : 'published';
        $blogPost->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : null
        ]);
        return back()->with('success', 'Article status updated to ' . $newStatus . '.');
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', \Illuminate\Validation\Rules\Password::defaults(), 'confirmed'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function bookings()
    {
        $bookings = Booking::with(['customer', 'provider', 'service'])
            ->latest()
            ->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['booking.customer', 'booking.provider'])
            ->latest()
            ->get();
        return view('admin.transactions', compact('transactions'));
    }
}
