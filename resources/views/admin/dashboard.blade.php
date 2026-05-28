@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
@php
    $displayPendingProviders = $pendingProviders;
    $displayServices = $latestServices;
    $displayBlogs = $blogPosts;
    $displayBookings = $recentBookings;
    $displayReviews = $recentReviews;

    // Segmented revenue distribution (actual transaction data)
    $serviceBookingsRev = $totalRevenue;
    $providerPlansRev = 0;
    $otherEarningsRev = 0;
@endphp

<div class="flex h-screen bg-[#FAFCFB] font-sans overflow-hidden">

    @include('admin-dashboard-sidebar')

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        @include('admin-dashboard-header')

        <!-- Scrollable Dashboard Content -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#FAFCFB] space-y-8">
            
            @if (session('success'))
                <div id="success-alert" class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-sm text-xs font-bold flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </span>
                    <button onclick="document.getElementById('success-alert').remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            <!-- Title Header -->
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Admin Dashboard</h1>
                <p class="text-[12px] text-gray-400 font-medium mt-0.5">Manage and monitor your platform from here.</p>
            </div>

            <!-- Analytics Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-5">
                
                <!-- Total Users -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-users text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Total Users</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($usersTrend['dir'] === 'up') text-[#3E8B3A] @elseif($usersTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($usersTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($usersTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $usersTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

                <!-- Verified Providers -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-shield text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Verified</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">{{ number_format($verifiedProvidersCount) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($verifiedTrend['dir'] === 'up') text-[#3E8B3A] @elseif($verifiedTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($verifiedTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($verifiedTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $verifiedTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

                <!-- Active Services -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E3F2FD] text-[#1565C0] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-briefcase text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Services</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">{{ number_format($totalServices) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($servicesTrend['dir'] === 'up') text-[#3E8B3A] @elseif($servicesTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($servicesTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($servicesTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $servicesTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#F3E5F5] text-[#6A1B9A] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-calendar-check text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Bookings</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">{{ number_format($totalBookings) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($bookingsTrend['dir'] === 'up') text-[#3E8B3A] @elseif($bookingsTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($bookingsTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($bookingsTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $bookingsTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

                <!-- Average Rating -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#FFF8E1] text-[#FF8F00] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-star text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Avg Rating</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">{{ number_format($averageRating, 1) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($ratingTrend['dir'] === 'up') text-[#3E8B3A] @elseif($ratingTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($ratingTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($ratingTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $ratingTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.01)] flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-money-bill-wave text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider">Revenue</p>
                            <h3 class="text-lg font-black text-gray-900 mt-0.5">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] @if($revenueTrend['dir'] === 'up') text-[#3E8B3A] @elseif($revenueTrend['dir'] === 'down') text-[#C62828] @else text-gray-400 @endif font-bold mt-4 flex items-center gap-1">
                        @if($revenueTrend['dir'] === 'up')
                            <i class="fa-solid fa-arrow-up text-[8px]"></i>
                        @elseif($revenueTrend['dir'] === 'down')
                            <i class="fa-solid fa-arrow-down text-[8px]"></i>
                        @endif
                        {{ $revenueTrend['label'] }} <span class="text-gray-400 font-medium">vs last month</span>
                    </div>
                </div>

            </div>

            <!-- Two Column Layout Body -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Left Side Content Cards -->
                <div class="space-y-8">
                    
                    <!-- Providers Pending Verification -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Providers Pending Verification</h3>
                            <a href="{{ route('admin.providers') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <th class="pb-3 pr-4">Provider</th>
                                        <th class="pb-3 pr-4">Business Details</th>
                                        <th class="pb-3 pr-4">Applied On</th>
                                        <th class="pb-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @if($displayPendingProviders->isEmpty())
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-400 font-medium italic">
                                                No providers pending verification.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($displayPendingProviders as $provider)
                                            <tr class="text-[12px] text-gray-700">
                                                <td class="py-3.5 pr-4 flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#E8F5E9] text-[#2E6F40] font-black text-xs flex items-center justify-center shrink-0">
                                                        {{ strtoupper(substr($provider->name, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <h4 class="font-extrabold text-gray-900">{{ $provider->name }}</h4>
                                                        <p class="text-[10px] text-gray-400 font-medium">{{ $provider->email }}</p>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 pr-4">
                                                    @if(isset($provider->profile_completed) && $provider->profile_completed)
                                                        <h4 class="font-bold text-gray-900 leading-snug">{{ $provider->business_name }}</h4>
                                                        <p class="text-[10px] text-gray-400 font-semibold flex items-center gap-0.5">
                                                            <i class="fa-solid fa-location-dot text-[8px] text-[#3E8B3A]"></i>
                                                            {{ $provider->city }}, {{ $provider->state }}
                                                        </p>
                                                    @else
                                                        <span class="text-gray-400 italic">Profile Incomplete</span>
                                                    @endif
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-medium">
                                                    {{ is_string($provider->created_at) ? $provider->created_at : $provider->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="py-3.5 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <form method="POST" action="{{ route('admin.verifyProvider', $provider->id) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" title="Verify Provider" class="w-7 h-7 rounded-lg bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center hover:bg-[#C8E6C9] transition-colors shadow-sm">
                                                                <i class="fa-solid fa-check text-[11px]"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.declineProvider', $provider->id) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" title="Decline Provider" class="w-7 h-7 rounded-lg bg-[#FFEBEE] text-[#C62828] flex items-center justify-center hover:bg-[#FFCDD2] transition-colors shadow-sm">
                                                                <i class="fa-solid fa-xmark text-[11px]"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
 
                    <!-- Latest Services -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Latest Services</h3>
                            <a href="{{ route('services.list') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <th class="pb-3 pr-4">Service</th>
                                        <th class="pb-3 pr-4">Provider</th>
                                        <th class="pb-3 pr-4">Category</th>
                                        <th class="pb-3 pr-4">Location</th>
                                        <th class="pb-3 pr-4">Added On</th>
                                        <th class="pb-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @if($displayServices->isEmpty())
                                        <tr>
                                            <td colspan="6" class="py-8 text-center text-gray-400 font-medium italic">
                                                No services registered.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($displayServices as $service)
                                            <tr class="text-[12px] text-gray-700">
                                                <td class="py-3.5 pr-4 flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 border border-green-100">
                                                        <i class="fa-solid fa-recycle text-[11px] text-[#3E8B3A]"></i>
                                                    </div>
                                                    <h4 class="font-extrabold text-gray-900 leading-snug">{{ $service->name }}</h4>
                                                </td>
                                                <td class="py-3.5 pr-4 font-bold text-gray-900">
                                                    {{ $service->user->business_name ?? 'Provider' }}
                                                </td>
                                                <td class="py-3.5 pr-4">
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-[#E8F5E9] text-[#2E6F40]">
                                                        {{ $service->category ?: 'General' }}
                                                    </span>
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-semibold">
                                                    {{ $service->city ?: 'All Locations' }}
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-medium">
                                                    {{ is_string($service->created_at) ? $service->created_at : $service->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="py-3.5 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('services.list') }}?search={{ urlencode($service->name) }}" class="w-7 h-7 rounded-lg bg-[#E3F2FD] text-[#1565C0] flex items-center justify-center hover:bg-[#BBDEFB] transition-colors shadow-sm">
                                                            <i class="fa-solid fa-eye text-[11px]"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" title="Delete Service" class="w-7 h-7 rounded-lg bg-[#FFEBEE] text-[#C62828] flex items-center justify-center hover:bg-[#FFCDD2] transition-colors shadow-sm">
                                                                <i class="fa-solid fa-trash-can text-[11px]"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
 
                    <!-- Blog Overview -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Blog Overview</h3>
                            <a href="{{ route('admin.blog.all-articles') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <th class="pb-3 pr-4">Blog Title</th>
                                        <th class="pb-3 pr-4">Author</th>
                                        <th class="pb-3 pr-4">Status</th>
                                        <th class="pb-3 pr-4">Published On</th>
                                        <th class="pb-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @if($displayBlogs->isEmpty())
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 font-medium italic">
                                                No blog posts found.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($displayBlogs as $blog)
                                            <tr class="text-[12px] text-gray-700">
                                                <td class="py-3.5 pr-4 font-extrabold text-gray-900 leading-snug max-w-xs truncate">
                                                    {{ $blog->title }}
                                                </td>
                                                <td class="py-3.5 pr-4 font-bold text-gray-900">
                                                    {{ $blog->author->name ?? 'Admin' }}
                                                </td>
                                                <td class="py-3.5 pr-4">
                                                    @if($blog->status === 'published')
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-[#E8F5E9] text-[#2E6F40]">Published</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-[#FFF3E0] text-[#E65100]">Draft</span>
                                                    @endif
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-medium">
                                                    {{ is_string($blog->published_at) ? $blog->published_at : ($blog->published_at ? $blog->published_at->format('M d, Y') : 'N/A') }}
                                                </td>
                                                <td class="py-3.5 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('blog.edit', $blog->id) }}" class="w-7 h-7 rounded-lg bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center hover:bg-[#C8E6C9] transition-colors shadow-sm">
                                                            <i class="fa-solid fa-pencil text-[11px]"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('admin.blog.destroy', $blog->id) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" title="Delete Blog Post" class="w-7 h-7 rounded-lg bg-[#FFEBEE] text-[#C62828] flex items-center justify-center hover:bg-[#FFCDD2] transition-colors shadow-sm">
                                                                <i class="fa-solid fa-trash-can text-[11px]"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
 
                </div>
 
                <!-- Right Side Content Cards -->
                <div class="space-y-8">
                    
                    <!-- Recent Bookings -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Recent Bookings</h3>
                            <a href="{{ route('admin.bookings') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <th class="pb-3 pr-4">Customer</th>
                                        <th class="pb-3 pr-4">Provider</th>
                                        <th class="pb-3 pr-4">Service</th>
                                        <th class="pb-3 pr-4">Date</th>
                                        <th class="pb-3 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @if($displayBookings->isEmpty())
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 font-medium italic">
                                                No recent bookings.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($displayBookings as $booking)
                                            <tr class="text-[12px] text-gray-700">
                                                <td class="py-3.5 pr-4 flex items-center gap-3">
                                                    <div class="w-7 h-7 rounded-full bg-[#E3F2FD] text-[#1565C0] font-black text-[11px] flex items-center justify-center shrink-0">
                                                        {{ strtoupper(substr($booking->customer->name ?? 'Cust', 0, 2)) }}
                                                    </div>
                                                    <span class="font-extrabold text-gray-900 leading-snug">{{ $booking->customer->name ?? 'Customer' }}</span>
                                                </td>
                                                <td class="py-3.5 pr-4 font-bold text-gray-900 leading-snug">
                                                    {{ $booking->provider->business_name ?? 'Provider' }}
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-semibold leading-snug">
                                                    {{ $booking->service->name ?? 'Service' }}
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-medium">
                                                    {{ is_string($booking->scheduled_at) ? $booking->scheduled_at : $booking->scheduled_at->format('M d, Y') }}
                                                </td>
                                                <td class="py-3.5 text-right">
                                                    @if($booking->status === 'completed')
                                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#E8F5E9] text-[#2E6F40]">Completed</span>
                                                    @elseif($booking->status === 'confirmed')
                                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#E3F2FD] text-[#1565C0]">Confirmed</span>
                                                    @elseif($booking->status === 'cancelled')
                                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFEBEE] text-[#C62828]">Cancelled</span>
                                                    @else
                                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFF3E0] text-[#E65100]">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
 
                    <!-- Recent Reviews -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Recent Reviews</h3>
                            <a href="{{ route('admin.reviews') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                                        <th class="pb-3 pr-4">Reviewer</th>
                                        <th class="pb-3 pr-4">Provider</th>
                                        <th class="pb-3 pr-4">Rating</th>
                                        <th class="pb-3 pr-4">Review</th>
                                        <th class="pb-3 text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @if($displayReviews->isEmpty())
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 font-medium italic">
                                                No recent reviews.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($displayReviews as $review)
                                            <tr class="text-[12px] text-gray-700">
                                                <td class="py-3.5 pr-4 flex items-center gap-3">
                                                    <div class="w-7 h-7 rounded-full bg-[#FFF8E1] text-[#FF8F00] font-black text-[11px] flex items-center justify-center shrink-0">
                                                        {{ strtoupper(substr($review->user->name ?? 'User', 0, 2)) }}
                                                    </div>
                                                    <span class="font-extrabold text-gray-900 leading-snug">{{ $review->user->name ?? 'User' }}</span>
                                                </td>
                                                <td class="py-3.5 pr-4 font-bold text-gray-900 leading-snug">
                                                    {{ $review->provider->business_name ?? 'Provider' }}
                                                </td>
                                                <td class="py-3.5 pr-4 text-[#FF8F00] font-bold">
                                                    <div class="flex items-center gap-0.5">
                                                        @for($i = 0; $i < 5; $i++)
                                                            @if($i < $review->rating)
                                                                <i class="fa-solid fa-star text-[10px]"></i>
                                                            @else
                                                                <i class="fa-regular fa-star text-[10px] text-gray-200"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td class="py-3.5 pr-4 text-gray-400 font-medium leading-snug max-w-xs truncate" title="{{ $review->comment }}">
                                                    {{ $review->comment }}
                                                </td>
                                                <td class="py-3.5 text-right text-gray-400 font-medium">
                                                    {{ is_string($review->created_at) ? $review->created_at : $review->created_at->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
 
                    <!-- Revenue Overview Chart Card -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.01)] p-6">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[14px] font-extrabold text-gray-900">Revenue Overview</h3>
                            <a href="{{ route('admin.transactions') }}" class="text-[#3E8B3A] text-xs font-extrabold hover:text-[#2E6F40] transition-colors">View All</a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center justify-around gap-8">
                            <!-- Circular Graphic -->
                            <div class="relative w-36 h-36 flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="#F4F6F5" stroke-width="12" fill="none" />
                                    <!-- Service Bookings Arc (100% if totalRevenue > 0) -->
                                    <circle cx="50" cy="50" r="40" stroke="#3E8B3A" stroke-width="12" fill="none" stroke-dasharray="251.2" stroke-dashoffset="{{ $totalRevenue > 0 ? 0 : 251.2 }}" />
                                </svg>
                                <div class="absolute text-center leading-tight">
                                    <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-wider leading-none">Total Earnings</p>
                                    <h4 class="text-[16px] font-black text-gray-900 mt-1">${{ number_format($totalRevenue, 2) }}</h4>
                                    <p class="text-[9px] text-[#3E8B3A] font-extrabold mt-0.5">↑ 16.8% <span class="text-[8px] text-gray-400 font-medium">vs last month</span></p>
                                </div>
                            </div>
 
                            <!-- Legend List -->
                            <div class="space-y-4 text-xs font-semibold text-gray-700 w-full sm:w-auto shrink-0">
                                <div class="flex items-center justify-between gap-10">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#3E8B3A]"></span>
                                        <span class="text-gray-500">Service Bookings</span>
                                    </div>
                                    <span class="font-extrabold text-gray-900">${{ number_format($serviceBookingsRev, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-10">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#2196F3]"></span>
                                        <span class="text-gray-500">Provider Plans</span>
                                    </div>
                                    <span class="font-extrabold text-gray-900">${{ number_format($providerPlansRev, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-10">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#FFC107]"></span>
                                        <span class="text-gray-500">Other Earnings</span>
                                    </div>
                                    <span class="font-extrabold text-gray-900">${{ number_format($otherEarningsRev, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
 
                </div>
 
            </div>
 
        </main>
 
    </div>
 
</div>
 
@endsection
