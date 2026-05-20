@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    @include('provider-dashboard-sidebar')

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <!-- Scrollable Dashboard Content Body -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10">

        @if(!$provider->is_verified)
            <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="font-bold text-[13px]">Account Pending Verification</p>
                        <p class="text-[11px] mt-0.5 text-yellow-700">Your profile is currently being reviewed. You will be able to manage services once verified.</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-[10px] font-bold uppercase tracking-wider">Pending</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-[20px] font-bold text-gray-900 mb-1 tracking-tight">Dashboard Overview</h1>
                <p class="text-[12px] text-gray-500 font-medium">Hello {{ explode(' ', $provider->name)[0] }}, here is your composting platform activity today.</p>
            </div>
            <a href="{{ route('services.create') }}" class="bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add New Service</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            <!-- Card 1 -->
            <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" />
                            <rect x="14" y="3" width="7" height="7" rx="1.5" />
                            <rect x="14" y="14" width="7" height="7" rx="1.5" />
                            <rect x="3" y="14" width="7" height="7" rx="1.5" />
                        </svg>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Total Services</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $totalServices }}</span>
                        <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">↑ 2 new</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Total Bookings</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $totalBookings }}</span>
                        <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">↑ 15%</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M6 3h12" />
                            <path d="M6 8h12" />
                            <path d="m6 13 8.5 8" />
                            <path d="M6 13h3" />
                            <path d="M9 13c6.667 0 6.667-10 0-10" />
                        </svg>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Total Earnings</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">₹{{ number_format($totalEarnings, 0) }}</span>
                        <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">↑ 18%</span>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Avg. Rating</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">{{ $totalReviews }} reviews</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-[13px] font-bold text-gray-800">Earnings Overview</h2>
                    <select class="border border-gray-200 rounded-xl px-4 py-1.5 text-xs font-medium text-gray-600 bg-white shadow-sm focus:outline-none focus:ring-1 focus:ring-provider-green">
                        <option>This Month</option>
                        <option>Last Month</option>
                    </select>
                </div>
                <div class="h-[250px] relative">
                    <canvas id="earningsChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col">
                <h2 class="text-[13px] font-bold text-gray-800 mb-6">Bookings Overview</h2>
                <div class="flex-1 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-6 relative min-h-[140px]">
                    <div class="w-[140px] h-[140px] relative shrink-0">
                        <canvas id="bookingsChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <p class="text-[24px] font-bold text-gray-800 leading-none">{{ $totalBookings }}</p>
                            <p class="text-[10px] text-gray-500 font-medium mt-1">Total</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-4 text-xs font-medium text-gray-600 w-full sm:w-auto">
                        <div class="flex flex-col">
                            <span class="flex items-center gap-2 text-gray-700 font-semibold mb-1"><span class="w-2.5 h-2.5 bg-provider-green rounded-full shrink-0"></span>Completed</span>
                            <span class="text-gray-400 ml-4.5">{{ $bookings->where('status', 'completed')->count() }} ({{ $totalBookings > 0 ? round($bookings->where('status', 'completed')->count() / $totalBookings * 100) : 0 }}%)</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="flex items-center gap-2 text-gray-700 font-semibold mb-1"><span class="w-2.5 h-2.5 bg-[#8cc67b] rounded-full shrink-0"></span>Upcoming</span>
                            <span class="text-gray-400 ml-4.5">{{ $bookings->where('status', 'confirmed')->count() }} ({{ $totalBookings > 0 ? round($bookings->where('status', 'confirmed')->count() / $totalBookings * 100) : 0 }}%)</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="flex items-center gap-2 text-gray-700 font-semibold mb-1"><span class="w-2.5 h-2.5 bg-gray-200 rounded-full shrink-0"></span>Cancelled</span>
                            <span class="text-gray-400 ml-4.5">{{ $bookings->where('status', 'cancelled')->count() }} ({{ $totalBookings > 0 ? round($bookings->where('status', 'cancelled')->count() / $totalBookings * 100) : 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Completion & Recent/Upcoming -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-1 bg-provider-green text-white p-7 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] flex flex-col relative overflow-hidden order-first lg:order-last">
                <!-- Leaf background decoration -->
                <svg class="absolute bottom-0 right-0 w-48 h-48 text-[#5ba147] opacity-30 translate-x-12 translate-y-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>

                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-[13px] font-bold text-white tracking-wide">Complete Your Profile</h2>
                        <span class="text-[11px] font-semibold text-white">{{ $profileCompletion }}% Complete</span>
                    </div>
                    <div class="w-full bg-provider-green-dark/40 rounded-full h-1.5 mb-5 overflow-hidden">
                        <div class="bg-white h-1.5 rounded-full" style="width: {{ $profileCompletion }}%"></div>
                    </div>
                    <p class="text-white/90 mb-6 text-xs leading-relaxed font-medium">Add more details to build trust and attract more customers.</p>
                    <ul class="space-y-4 text-xs font-semibold text-white flex-grow">
                        <!-- Step 1: Basic Info -->
                        <li class="flex items-center gap-3">
                            @if($hasBasicInfo)
                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Basic Information</span>
                            @else
                                <div class="w-4 h-4 rounded-full border-2 border-white/60 flex-shrink-0"></div>
                                <span class="opacity-90">Basic Information</span>
                            @endif
                        </li>
                        
                        <!-- Step 2: Profile Picture -->
                        <li class="flex items-center gap-3">
                            @if($hasProfilePic)
                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Profile Picture</span>
                            @else
                                <div class="w-4 h-4 rounded-full border-2 border-white/60 flex-shrink-0"></div>
                                <span class="opacity-90">Profile Picture</span>
                            @endif
                        </li>

                        <!-- Step 3: Business Details -->
                        <li class="flex items-center gap-3">
                            @if($hasBusinessDetails)
                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Business Details</span>
                            @else
                                <div class="w-4 h-4 rounded-full border-2 border-white/60 flex-shrink-0"></div>
                                <span class="opacity-90">Business Details</span>
                            @endif
                        </li>

                        <!-- Step 4: Service Location -->
                        <li class="flex items-center gap-3">
                            @if($hasServiceLocation)
                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Service Location</span>
                            @else
                                <div class="w-4 h-4 rounded-full border-2 border-white/60 flex-shrink-0"></div>
                                <span class="opacity-90">Service Location</span>
                            @endif
                        </li>

                        <!-- Step 5: Bank Details -->
                        <li class="flex items-center gap-3">
                            @if($hasBankDetails)
                                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Bank Details</span>
                            @else
                                <div class="w-4 h-4 rounded-full border-2 border-white/60 flex-shrink-0"></div>
                                <span class="opacity-90">Bank Details</span>
                            @endif
                        </li>
                    </ul>
                    <a href="{{ route('provider.profile.edit') }}" class="w-full text-center bg-provider-green-dark hover:bg-black text-white font-bold py-3 px-4 rounded-xl mt-8 text-xs transition-colors shadow-sm inline-block select-none active:scale-[0.98]">Complete Now</a>
                </div>
            </div>

            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Services -->
                <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-[13px] font-bold text-gray-800">Your Recent Services</h2>
                        <a href="{{ route('services.index') }}" class="text-[11px] font-bold text-provider-green hover:underline">View All</a>
                    </div>
                    <div class="flex-1 space-y-6 text-sm">
                        @forelse($recentServices as $service)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($service->name) }}&background=eef6ea&color=40852b" alt="Service" class="w-11 h-11 rounded-xl object-cover">
                                <div>
                                    <p class="font-bold text-gray-900 text-[13px] leading-snug">{{ $service->name }}</p>
                                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Bengaluru</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-2.5 py-1 rounded-md">Active</span>
                                <div class="text-right w-12 hidden sm:block">
                                    <p class="font-bold text-gray-900 text-sm">{{ $service->bookings->count() }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium">Bookings</p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg></button>
                            </div>
                        </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4 font-medium">No recent services found.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Bookings -->
                <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-[13px] font-bold text-gray-800">Upcoming Bookings</h2>
                        <a href="{{ route('bookings.index') }}" class="text-[11px] font-bold text-provider-green hover:underline">View All</a>
                    </div>
                    <div class="flex-1 space-y-6 text-sm">
                        @forelse($upcomingBookings as $booking)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="bg-gray-50 text-provider-green w-11 h-11 flex items-center justify-center rounded-xl shrink-0 border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-[13px] leading-snug truncate max-w-[140px]">{{ $booking->service->name }}</p>
                                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">{{ \Carbon\Carbon::parse($booking->scheduled_at)->format('M d, Y • h:i A') }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-provider-green bg-provider-green-light border border-transparent px-2.5 py-1 rounded-md">{{ ucfirst($booking->status) }}</span>
                        </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4 font-medium">No upcoming bookings.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grow Your Impact -->
        <div class="bg-provider-green-light p-6 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/earth-care.svg') }}" alt="Icon" class="w-full h-full object-contain drop-shadow-sm brightness-110">
                </div>
                <div>
                    <h2 class="text-[16px] font-bold text-provider-green-dark">Grow Your Impact</h2>
                    <p class="text-[12px] font-medium text-provider-green-dark/70 mt-0.5">Add more services and help more people live a sustainable life.</p>
                </div>
            </div>
            <a href="{{ route('services.create') }}" class="relative z-10 bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shrink-0 mr-8">
                <span>Add New Service</span>
            </a>
            <button class="text-provider-green-dark/50 hover:text-provider-green-dark absolute right-6 top-1/2 -translate-y-1/2 hidden sm:block z-10 transition-colors">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Earnings Chart
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        
        // Gradient for line chart (matching provider-green #40852b)
        let gradient = earningsCtx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(64, 133, 43, 0.25)');   
        gradient.addColorStop(1, 'rgba(64, 133, 43, 0.01)');

        new Chart(earningsCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Earnings',
                    data: @json($chartData),
                    backgroundColor: gradient,
                    borderColor: '#40852b', // provider-green
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#40852b',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                family: "'Inter', sans-serif"
                            },
                            color: '#9CA3AF'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + (value/1000) + 'k';
                            },
                            font: {
                                size: 11,
                                family: "'Inter', sans-serif"
                            },
                            color: '#9CA3AF',
                            padding: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#1F2937',
                        bodyColor: '#1F2937',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        titleFont: {
                            size: 11,
                            weight: 'normal'
                        },
                        bodyFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '₹' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Bookings Chart
        const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
        new Chart(bookingsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Upcoming', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $bookings->where('status', 'completed')->count() }},
                        {{ $bookings->where('status', 'confirmed')->count() }},
                        {{ $bookings->where('status', 'cancelled')->count() }}
                    ],
                    backgroundColor: [
                        '#40852b', // provider-green
                        '#8cc67b', // light green
                        '#E5E7EB'  // gray
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        padding: 10,
                        bodyFont: {
                            size: 13
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
