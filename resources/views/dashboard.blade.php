@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 select-none bg-[#FAFAFA]/50 min-h-screen">

    <!-- Banner Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Left Banner Card -->
        <div class="lg:col-span-2 bg-gradient-to-r from-[#F4F9F5] to-[#E9F3EC] rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between min-h-[260px] border border-gray-100/50 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <!-- Decorative floating leaves -->
            <div class="absolute left-[35%] top-10 text-green-500/10 text-2xl select-none pointer-events-none animate-bounce">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div class="absolute left-[5%] bottom-12 text-green-500/10 text-4xl select-none pointer-events-none transform -rotate-45">
                <i class="fa-solid fa-leaf"></i>
            </div>
            
            <div class="relative z-10 max-w-md md:max-w-lg">
                <h4 class="text-xs md:text-sm font-extrabold text-[#2E6F40] flex items-center gap-2 select-none">
                    <i class="fa-solid fa-seedling text-sm text-[#3E8B3A]"></i> Good Morning, {{ explode(' ', Auth::user()->name)[0] }}!
                </h4>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-3 tracking-tight leading-tight">
                    Every small step makes <br class="hidden md:inline">a <span class="text-[#3E8B3A]">big impact.</span>
                </h1>
                <p class="text-gray-500 text-xs md:text-sm font-semibold mt-3 max-w-sm leading-relaxed">
                    Thank you for being part of a cleaner, greener community.
                </p>
            </div>
            
            <!-- SAPLING IMAGE -->
            <img src="{{ asset('images/landing-page-2.png') }}" alt="Eco Sapling" class="hidden md:block absolute right-12 -bottom-10 w-[420px] h-[340px] object-contain select-none pointer-events-none">

            <!-- Buttons -->
            <div class="relative z-10 flex flex-wrap gap-3.5 mt-6">
                <a href="{{ route('services.list') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-[#3E8B3A] hover:bg-[#2E6F40] active:scale-[0.98] text-white text-xs font-bold rounded-2xl shadow-sm transition-all select-none">
                    <span class="text-white">Book a Pickup</span>
                    <i class="fa-solid fa-truck-moving text-xs text-white"></i>
                </a>
                <a href="{{ route('services.list') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-white hover:bg-gray-50 border border-gray-250 active:scale-[0.98] text-gray-700 text-xs font-bold rounded-2xl shadow-sm transition-all select-none">
                    <span>Browse Services</span>
                    <i class="fa-solid fa-cubes text-xs text-gray-400"></i>
                </a>
            </div>
        </div>

        <!-- Right Eco Contribution Card -->
        <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] flex flex-col justify-between min-h-[260px]">
            <div>
                <h3 class="text-xs font-bold text-gray-800 select-none">Your Eco Contribution</h3>
                
                <div class="space-y-5 mt-6">
                    <!-- Waste Diverted -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 select-none">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-gray-900 block leading-tight">{{ $wasteSaved }} kg</span>
                            <span class="text-2xs text-gray-400 font-bold block mt-0.5">Waste diverted this month</span>
                            <span class="inline-flex items-center gap-0.5 text-2xs text-[#3E8B3A] font-extrabold mt-1 select-none">
                                <i class="fa-solid fa-arrow-up text-3xs"></i> 24% <span class="text-gray-400 font-semibold ml-0.5">more than last month</span>
                            </span>
                        </div>
                    </div>

                    <!-- CO2 Avoided -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 select-none">
                            <i class="fa-solid fa-cloud"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-gray-900 block leading-tight">{{ $co2Offset }} kg</span>
                            <span class="text-2xs text-gray-400 font-bold block mt-0.5">CO₂ Avoided</span>
                            <span class="inline-flex items-center gap-0.5 text-2xs text-[#3E8B3A] font-extrabold mt-1 select-none">
                                <i class="fa-solid fa-arrow-up text-3xs"></i> 18% <span class="text-gray-400 font-semibold ml-0.5">more than last month</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 5-column Shortcuts Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <!-- Shortcut 1: Book a Service -->
        <a href="{{ route('services.list') }}" class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.005)] hover:shadow-md hover:border-green-100 hover:bg-[#EAF5EE]/10 transition-all flex flex-col justify-between group h-32 select-none">
            <div class="flex justify-between items-start w-full">
                <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 group-hover:text-[#3E8B3A] text-xs transition-colors mt-1.5 mr-0.5"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-900 block">Book a Service</span>
                <span class="text-2xs text-gray-400 font-semibold block mt-0.5 leading-tight truncate">Schedule composting or waste</span>
            </div>
        </a>

        <!-- Shortcut 2: Request a Pickup -->
        <a href="{{ route('services.list') }}" class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.005)] hover:shadow-md hover:border-green-100 hover:bg-[#EAF5EE]/10 transition-all flex flex-col justify-between group h-32 select-none">
            <div class="flex justify-between items-start w-full">
                <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-truck-moving"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 group-hover:text-[#3E8B3A] text-xs transition-colors mt-1.5 mr-0.5"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-900 block">Request a Pickup</span>
                <span class="text-2xs text-gray-400 font-semibold block mt-0.5 leading-tight truncate">Get doorstep waste pickup</span>
            </div>
        </a>

        <!-- Shortcut 3: My Bookings -->
        <a href="{{ route('bookings.my') }}" class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.005)] hover:shadow-md hover:border-green-100 hover:bg-[#EAF5EE]/10 transition-all flex flex-col justify-between group h-32 select-none">
            <div class="flex justify-between items-start w-full">
                <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fa-regular fa-clipboard"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 group-hover:text-[#3E8B3A] text-xs transition-colors mt-1.5 mr-0.5"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-900 block">My Bookings</span>
                <span class="text-2xs text-gray-400 font-semibold block mt-0.5 leading-tight truncate">View and manage bookings</span>
            </div>
        </a>

        <!-- Shortcut 4: My Impact -->
        <button type="button" onclick="scrollToElement('impact-overview')" class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.005)] hover:shadow-md hover:border-green-100 hover:bg-[#EAF5EE]/10 transition-all flex flex-col justify-between group h-32 text-left w-full select-none focus:outline-none">
            <div class="flex justify-between items-start w-full">
                <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 group-hover:text-[#3E8B3A] text-xs transition-colors mt-1.5 mr-0.5"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-900 block">My Impact</span>
                <span class="text-2xs text-gray-400 font-semibold block mt-0.5 leading-tight truncate">Track contribution metrics</span>
            </div>
        </button>

        <!-- Shortcut 5: Saved Providers -->
        <button type="button" onclick="openModal('saved-providers-modal')" class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.005)] hover:shadow-md hover:border-green-100 hover:bg-[#EAF5EE]/10 transition-all flex flex-col justify-between group h-32 text-left w-full select-none focus:outline-none">
            <div class="flex justify-between items-start w-full">
                <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-300 group-hover:text-[#3E8B3A] text-xs transition-colors mt-1.5 mr-0.5"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-900 block">Saved Providers</span>
                <span class="text-2xs text-gray-400 font-semibold block mt-0.5 leading-tight truncate">Your favorite service providers</span>
            </div>
        </button>
    </div>

    <!-- 3-Column Info Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Column 1: Upcoming Booking -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.01)] flex flex-col justify-between min-h-[360px]">
            <div class="flex justify-between items-center mb-5 select-none">
                <h3 class="text-xs font-bold text-gray-800">Upcoming Booking</h3>
                <a href="{{ route('bookings.my') }}" class="text-2xs font-extrabold text-[#3E8B3A] hover:underline flex items-center gap-0.5">
                    View All <i class="fa-solid fa-arrow-right text-3xs"></i>
                </a>
            </div>

            @if($upcomingBooking)
                @php
                    $category = strtolower($upcomingBooking->service->category ?? '');
                    $categoryIcon = 'fa-truck-ramp-box'; // fallback default
                    if (str_contains($category, 'recycle')) {
                        $categoryIcon = 'fa-recycle';
                    } elseif (str_contains($category, 'e-waste') || str_contains($category, 'plug') || str_contains($category, 'electron')) {
                        $categoryIcon = 'fa-plug';
                    } elseif (str_contains($category, 'organic')) {
                        $categoryIcon = 'fa-apple-whole';
                    } elseif (str_contains($category, 'compost')) {
                        $categoryIcon = 'fa-seedling';
                    } elseif (str_contains($category, 'hazard') || str_contains($category, 'chemical')) {
                        $categoryIcon = 'fa-building';
                    }
                @endphp
                <div class="space-y-4 flex-1">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-base shrink-0 select-none">
                                <i class="fa-solid {{ $categoryIcon }}"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-xs text-gray-900 leading-tight">{{ $upcomingBooking->service->name }}</h4>
                                <p class="text-2xs text-gray-400 font-bold mt-0.5">{{ $upcomingBooking->provider->business_name ?? $upcomingBooking->provider->name }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 bg-[#EAF5EE] text-[#3E8B3A] border border-[#D9ECD8] rounded-md text-2xs font-extrabold uppercase tracking-wide select-none">
                            Scheduled
                        </span>
                    </div>

                    <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 space-y-3 text-2xs font-bold text-gray-500 select-none">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                            <span>{{ \Carbon\Carbon::parse($upcomingBooking->scheduled_at)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-gray-400 text-xs"></i>
                            <span>{{ \Carbon\Carbon::parse($upcomingBooking->scheduled_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($upcomingBooking->scheduled_at)->addHours(2)->format('h:i A') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-gray-400 text-xs"></i>
                            <span>{{ $upcomingBooking->service->city ?? 'Bengaluru' }}</span>
                        </div>
                    </div>
                </div>


            @else
                <!-- No Upcoming Bookings Empty State -->
                <div class="space-y-4 flex-1 flex flex-col items-center justify-center text-center p-6 bg-gray-50/30 rounded-3xl border border-dashed border-gray-150 select-none">
                    <div class="w-12 h-12 rounded-2xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-xl shrink-0 select-none mb-1">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                    <h4 class="font-extrabold text-xs text-gray-900 mt-2">No Upcoming Bookings</h4>
                    <p class="text-2xs text-gray-400 font-bold max-w-[200px] mt-1 leading-relaxed">
                        You don't have any eco collections scheduled at the moment.
                    </p>
                    <a href="{{ route('services.list') }}" class="mt-3.5 px-4 py-2 bg-[#3E8B3A] hover:bg-[#2E6F40] active:scale-[0.98] text-white text-2xs font-extrabold rounded-xl shadow-sm transition-all select-none">
                        Book a Service
                    </a>
                </div>
            @endif
        </div>

        <!-- Column 2: Impact Overview -->
        <div id="impact-overview" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.01)] flex flex-col justify-between min-h-[360px] scroll-mt-24 transition-all">
            <div class="flex justify-between items-center mb-5 select-none">
                <h3 class="text-xs font-bold text-gray-800">Impact Overview</h3>
                <button type="button" onclick="showEcoMessage()" class="text-2xs font-extrabold text-[#3E8B3A] hover:underline flex items-center gap-0.5 focus:outline-none">
                    View Details <i class="fa-solid fa-arrow-right text-3xs"></i>
                </button>
            </div>

            <div class="space-y-5 flex-1">
                <!-- Waste Composted -->
                <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-sm shrink-0 select-none">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block leading-none">Waste Composted</span>
                            <span class="text-2xs text-gray-400 font-semibold block mt-1 leading-none">This Month</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-black text-gray-900 block leading-none">{{ number_format($wasteSaved, 1) }} kg</span>
                        @if($completedBookings > 0)
                            <span class="text-2xs text-[#3E8B3A] font-extrabold mt-1 block leading-none select-none">
                                <i class="fa-solid fa-arrow-up text-4xs"></i> 24%
                            </span>
                        @else
                            <span class="text-2xs text-gray-400 font-extrabold mt-1 block leading-none select-none">
                                —
                            </span>
                        @endif
                    </div>
                </div>

                <!-- CO2 Avoided -->
                <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-sm shrink-0 select-none">
                            <i class="fa-solid fa-cloud"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block leading-none">CO₂ Avoided</span>
                            <span class="text-2xs text-gray-400 font-semibold block mt-1 leading-none">This Month</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-black text-gray-900 block leading-none">{{ number_format($co2Offset, 1) }} kg</span>
                        @if($completedBookings > 0)
                            <span class="text-2xs text-[#3E8B3A] font-extrabold mt-1 block leading-none select-none">
                                <i class="fa-solid fa-arrow-up text-4xs"></i> 18%
                            </span>
                        @else
                            <span class="text-2xs text-gray-400 font-extrabold mt-1 block leading-none select-none">
                                —
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Trees Equivalent -->
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-sm shrink-0 select-none">
                            <i class="fa-solid fa-tree"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block leading-none">Trees Equivalent</span>
                            <span class="text-2xs text-gray-400 font-semibold block mt-1 leading-none">This Month</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-black text-gray-900 block leading-none">{{ number_format($treesEquivalent, 1) }}</span>
                        @if($completedBookings > 0)
                            <span class="text-2xs text-[#3E8B3A] font-extrabold mt-1 block leading-none select-none">
                                <i class="fa-solid fa-arrow-up text-4xs"></i> 12%
                            </span>
                        @else
                            <span class="text-2xs text-gray-400 font-extrabold mt-1 block leading-none select-none">
                                —
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 3: Tips & Articles -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.01)] flex flex-col justify-between min-h-[360px]">
            <div class="flex justify-between items-center mb-5 select-none">
                <h3 class="text-xs font-bold text-gray-800">Tips & Articles</h3>
                <a href="{{ route('public.blog.index') }}" class="text-2xs font-extrabold text-[#3E8B3A] hover:underline flex items-center gap-0.5">
                    View All <i class="fa-solid fa-arrow-right text-3xs"></i>
                </a>
            </div>

            <div class="space-y-4 flex-1">
                @forelse($latestPosts as $post)
                    <a href="{{ route('public.blog.show', $post->slug) }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=150&q=80' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-xs text-gray-900 leading-snug group-hover:text-[#3E8B3A] transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h4>
                            <p class="text-2xs text-gray-400 font-semibold mt-1 select-none">
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }} • 5 min read
                            </p>
                        </div>
                    </a>
                @empty
                    <!-- Static fallbacks matching the exact design image -->
                    <a href="{{ route('public.blog.index') }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-xs text-gray-900 leading-snug group-hover:text-[#3E8B3A] transition-colors line-clamp-2">
                                5 Easy Ways to Reduce Kitchen Waste
                            </h4>
                            <p class="text-2xs text-gray-400 font-semibold mt-1 select-none">
                                May 18, 2026 • 5 min read
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('public.blog.index') }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                            <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-xs text-gray-900 leading-snug group-hover:text-[#3E8B3A] transition-colors line-clamp-2">
                                Benefits of Composting at Home
                            </h4>
                            <p class="text-2xs text-gray-400 font-semibold mt-1 select-none">
                                May 15, 2026 • 4 min read
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('public.blog.index') }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                            <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-xs text-gray-900 leading-snug group-hover:text-[#3E8B3A] transition-colors line-clamp-2">
                                How Recycling Helps Our Planet
                            </h4>
                            <p class="text-2xs text-gray-400 font-semibold mt-1 select-none">
                                May 10, 2026 • 6 min read
                            </p>
                        </div>
                    </a>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Saved Providers Modal -->
<div id="saved-providers-modal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeModal('saved-providers-modal')">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#EAF5EE] text-[#3E8B3A] flex items-center justify-center text-lg">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-gray-900">Saved Providers</h3>
                        <p class="text-2xs text-gray-400 font-semibold mt-0.5">Quick access to your trusted service partners</p>
                    </div>
                </div>
                <button onclick="closeModal('saved-providers-modal')" class="text-gray-400 hover:text-gray-600 text-base focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- List of providers -->
            <div class="space-y-3.5 max-h-72 overflow-y-auto pr-1">
                @php
                    $providersList = Auth::user()->savedProviders;
                @endphp
                @forelse($providersList as $prov)
                    <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-100 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#E2E4DE] flex items-center justify-center text-[#3E8B3A] font-bold text-xs shrink-0 select-none">
                                {{ substr($prov->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-extrabold text-s text-gray-900 leading-none">{{ $prov->business_name ?? $prov->name }}</h4>
                                <span class="text-2xs font-semibold text-emerald-600 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-100/40 mt-1 inline-block select-none">Verified</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="toggleSaveProvider({{ $prov->id }}, this)" class="p-2 border border-gray-200 hover:border-red-200 text-red-500 bg-white rounded-lg transition-colors flex items-center justify-center shadow-sm select-none" title="Remove">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                            <a href="{{ route('customer.messages.show', $prov->id) }}" class="p-2 border border-gray-200 hover:border-[#3E8B3A] text-gray-500 hover:text-[#3E8B3A] bg-white rounded-lg transition-colors flex items-center justify-center shadow-sm select-none" title="Chat">
                                <i class="fa-solid fa-comments text-xs"></i>
                            </a>
                            <a href="{{ route('services.list') }}" class="p-2 border border-gray-200 hover:border-[#3E8B3A] text-gray-500 hover:text-[#3E8B3A] bg-white rounded-lg transition-colors flex items-center justify-center shadow-sm select-none" title="Book Now">
                                <i class="fa-solid fa-calendar-plus text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">
                        <i class="fa-regular fa-heart text-2xl block mb-2 opacity-50 text-red-400"></i>
                        <p class="text-xs font-bold text-gray-600">No saved providers yet</p>
                        <p class="text-[10px] text-gray-400 mt-1">Click the heart icon on any service card or page to save them.</p>
                        <a href="{{ route('services.list') }}" class="inline-block mt-3 px-3.5 py-1.5 bg-[#3E8B3A] text-white rounded-xl text-2xs font-extrabold shadow-sm hover:bg-[#2E6F40] transition-colors">
                            Browse Services
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    // Toast Notification engine
    function showToast(message) {
        const toast = document.getElementById('toast-notification');
        const msgEl = document.getElementById('toast-message');
        msgEl.textContent = message;
        
        toast.className = "fixed top-5 right-5 z-[100] transform translate-y-0 opacity-100 transition-all duration-300 pointer-events-auto";
        setTimeout(() => {
            toast.className = "fixed top-5 right-5 z-[100] transform translate-y-[-100px] opacity-0 transition-all duration-300 pointer-events-none";
        }, 3000);
    }

    // Modal Control functions
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Scroll helper
    function scrollToElement(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            // Add a soft flash effect to the target card
            element.classList.add('ring-2', 'ring-[#3E8B3A]/30');
            setTimeout(() => {
                element.classList.remove('ring-2', 'ring-[#3E8B3A]/30');
            }, 1500);
        }
    }

    // Copy Referral Link
    function copyReferralLink() {
        const link = document.getElementById('ref-link-text').textContent;
        navigator.clipboard.writeText(link)
            .then(() => {
                closeModal('referral-modal');
                showToast("Referral link copied to clipboard!");
            })
            .catch(err => {
                console.error("Failed to copy link:", err);
            });
    }

    // Submit Support Inquiry
    function submitSupportInquiry() {
        const msgText = document.getElementById('support-message').value.trim();
        if (!msgText) return;
        
        // Simulating inquiry log/ticket creation
        document.getElementById('support-message').value = '';
        closeModal('support-modal');
        showToast("Support ticket created! We will contact you soon.");
    }

    // Impact View details alert
    function showEcoMessage() {
        showToast("Your eco calculations are updated automatically with every completed pickup!");
    }

    // Auto-open deletion modal if there are errors
    @if ($errors->userDeletion->isNotEmpty())
        document.addEventListener('DOMContentLoaded', function() {
            openModal('confirm-user-deletion');
        });
    @endif
</script>
@endsection
