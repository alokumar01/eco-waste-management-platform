@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    <!-- Sidebar -->
    @include('provider-dashboard-sidebar')

    @php
        $provider = Auth::user();
        
        // Count bookings by status
        $totalBookingsCount = count($bookings);
        $pendingCount = $bookings->where('status', 'pending')->count();
        $confirmedCount = $bookings->where('status', 'confirmed')->count();
        $completedCount = $bookings->where('status', 'completed')->count();
        $cancelledCount = $bookings->where('status', 'cancelled')->count();
        
        // Unique services for filter drop-down
        $uniqueServices = $bookings->pluck('service')->unique('id');
        
        // Calendar Setup for Current Month
        $now = \Carbon\Carbon::now();
        $monthName = $now->format('F Y');
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $daysInMonth = $now->daysInMonth;
        $startOfWeek = $startOfMonth->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
        
        // Group bookings by date for calendar dots mapping
        $bookingsByDate = [];
        foreach ($bookings as $b) {
            $dateStr = \Carbon\Carbon::parse($b->scheduled_at)->format('Y-m-d');
            $bookingsByDate[$dateStr][] = $b;
        }
    @endphp

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-xl shadow-sm select-none" role="alert">
                    <p class="font-bold text-xs">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Title Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-[22px] font-bold text-gray-950 leading-none tracking-tight">Bookings</h1>
                    <p class="text-[11.5px] text-gray-500 font-medium mt-1.5">Manage and track all your bookings in one place.</p>
                </div>
                <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 hover:border-gray-300 rounded-xl bg-white text-xs font-bold text-gray-700 shadow-sm transition-all shrink-0 select-none">
                    <i class="fa-solid fa-download text-gray-400 text-xs"></i>
                    <span>Export</span>
                </button>
            </div>

            <!-- Two Column Grid Area -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                
                <!-- Left Area: Bookings list feed (2/3 width) -->
                <div class="xl:col-span-2 space-y-6">
                    
                    <!-- Filter statuses Tabs Row -->
                    <div class="flex flex-wrap items-center gap-2 select-none border-b border-gray-200/60 pb-3">
                        <button type="button" id="tab_all" onclick="filterStatus('all', this)" class="px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-600 text-white shadow-sm border border-emerald-600">
                            All Bookings <span class="ml-1 text-[10px] opacity-90">{{ $totalBookingsCount }}</span>
                        </button>
                        <button type="button" id="tab_pending" onclick="filterStatus('pending', this)" class="px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Pending <span class="ml-1 bg-amber-50 text-amber-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-amber-200/50">{{ $pendingCount }}</span>
                        </button>
                        <button type="button" id="tab_confirmed" onclick="filterStatus('confirmed', this)" class="px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Confirmed <span class="ml-1 bg-blue-50 text-blue-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-blue-200/50">{{ $confirmedCount }}</span>
                        </button>
                        <button type="button" id="tab_completed" onclick="filterStatus('completed', this)" class="px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Completed <span class="ml-1 bg-emerald-50 text-emerald-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-emerald-200/50">{{ $completedCount }}</span>
                        </button>
                        <button type="button" id="tab_cancelled" onclick="filterStatus('cancelled', this)" class="px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Cancelled <span class="ml-1 bg-gray-50 text-gray-500 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-gray-200/50">{{ $cancelledCount }}</span>
                        </button>
                    </div>

                    <!-- Search, Services Filter and Dates Row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 bg-white p-4 rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.01)] select-none">
                        <!-- Search bar input -->
                        <div class="md:col-span-2 relative">
                            <input type="text" id="search_query" oninput="runFilters()" placeholder="Search by customer or service..." class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-xl text-xs bg-gray-50/20 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all text-gray-700 font-medium">
                            <i class="fa-solid fa-magnifying-glass text-gray-400 absolute right-3.5 top-1/2 -translate-y-1/2"></i>
                        </div>

                        <!-- Service Select Category filter -->
                        <div class="relative">
                            <select id="filter_service" onchange="runFilters()" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-xs text-gray-600 bg-gray-50/20 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer font-bold">
                                <option value="all">All Services</option>
                                @foreach ($uniqueServices as $serv)
                                    <option value="{{ $serv->id }}">{{ $serv->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Sort select option picker -->
                        <div class="relative">
                            <select id="sort_criteria" onchange="runFilters()" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-xs text-gray-600 bg-gray-50/20 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer font-bold">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="highest_price">Highest Amount</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Feed Column Cards -->
                    <div id="bookings_list" class="space-y-4">
                        
                        @forelse ($bookings as $booking)
                            @php
                                $statusColors = [
                                    'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/50'],
                                    'confirmed' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200/50'],
                                    'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200/50'],
                                    'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-800', 'border' => 'border-red-200/50'],
                                ];
                                $color = $statusColors[$booking->status] ?? $statusColors['pending'];
                            @endphp

                            <!-- Individual Booking Card Row -->
                            <div class="booking-row bg-white p-5 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.01)] hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-6"
                                 data-status="{{ $booking->status }}"
                                 data-service-id="{{ $booking->service->id }}"
                                 data-price="{{ $booking->price }}"
                                 data-timestamp="{{ \Carbon\Carbon::parse($booking->scheduled_at)->timestamp }}"
                                 data-searchable="{{ strtolower($booking->customer->name) }} {{ strtolower($booking->service->name) }}">
                                
                                <!-- Column 1: Image & Details block -->
                                <div class="flex items-start gap-4">
                                    <!-- Image Thumbnail -->
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 flex items-center justify-center select-none">
                                        @if ($booking->service->image_path)
                                            <img src="{{ asset('storage/' . $booking->service->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-[#E2E4DE] flex items-center justify-center select-none">
                                                <i class="fa-solid fa-leaf text-emerald-700 text-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Detail Text content -->
                                    <div class="space-y-1">
                                        <!-- Capsule Status Badge -->
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase border {{ $color['bg'] }} {{ $color['text'] }} {{ $color['border'] }} select-none">
                                            {{ $booking->status }}
                                        </span>
                                        
                                        <!-- Service Name -->
                                        <h4 class="font-extrabold text-[13.5px] text-gray-900 leading-tight">
                                            {{ $booking->service->name }}
                                        </h4>
                                        
                                        <!-- Date & address -->
                                        <div class="flex flex-col gap-1.5 text-[10.5px] text-gray-400 font-bold select-none pt-0.5">
                                            <span class="flex items-center gap-1.5 text-gray-500">
                                                <i class="fa-solid fa-calendar text-gray-400 text-xs"></i>
                                                {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('M d, Y • h:i A') }}
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-location-dot text-gray-400 text-xs"></i>
                                                {{ $booking->service->city }}, Bengaluru, 560038
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Customer info block -->
                                <div class="flex items-center gap-3 md:border-l md:border-r border-gray-100 px-0 md:px-6 shrink-0 select-none">
                                    <div class="w-8.5 h-8.5 rounded-full bg-[#E2E4DE] overflow-hidden flex items-center justify-center text-gray-600 font-bold text-xs border border-gray-100">
                                        @if ($booking->customer->profile_photo_path)
                                            <img src="{{ asset('storage/' . $booking->customer->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($booking->customer->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-[12.5px] text-gray-900 leading-none">{{ $booking->customer->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-semibold mt-1 tracking-wide leading-none">
                                            {{ $booking->customer->phone_number ?? '+91 98765 43210' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Column 3: Amount detail block -->
                                <div class="shrink-0 select-none">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider leading-none">Amount</p>
                                    <p class="text-base font-extrabold text-[#1B7339] mt-1 leading-none">
                                        ₹{{ number_format($booking->price, 0) }}
                                    </p>
                                </div>

                                <!-- Column 4: Functional buttons block -->
                                <div class="flex items-center gap-2 shrink-0 select-none">
                                    @if ($booking->status === 'pending')
                                        <!-- Accept Form Button -->
                                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[10.5px] py-1.5 px-3 rounded-lg transition-colors shadow-sm select-none">
                                                Accept
                                            </button>
                                        </form>

                                        <!-- Decline Form Button -->
                                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="border border-gray-200 hover:bg-gray-50 text-gray-600 font-extrabold text-[10.5px] py-1.5 px-3 rounded-lg transition-colors select-none">
                                                Decline
                                            </button>
                                        </form>

                                    @elseif($booking->status === 'confirmed')
                                        <!-- Mark as Completed Form Button -->
                                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="border border-emerald-600 hover:bg-emerald-50 text-emerald-800 font-extrabold text-[10.5px] py-1.5 px-3.5 rounded-lg transition-colors select-none">
                                                Mark as Completed
                                            </button>
                                        </form>

                                    @else
                                        <!-- View Details display -->
                                        <button type="button" class="border border-gray-200 hover:bg-gray-50 text-gray-500 font-extrabold text-[10.5px] py-1.5 px-3.5 rounded-lg transition-colors select-none">
                                            View Details
                                        </button>
                                    @endif

                                    <!-- Three Dot Vertical Menu Dropdown -->
                                    <div class="relative dropdown-container">
                                        <button type="button" onclick="toggleDropdown(this)" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-150 hover:bg-gray-50 text-gray-400 hover:text-gray-600 transition-colors select-none">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <!-- Dropdown Menu -->
                                        <div class="hidden dropdown-menu absolute right-0 mt-1 w-44 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden z-20">
                                            <a href="{{ route('messages.show', ['receiver' => $booking->customer->id, 'booking_id' => $booking->id]) }}" class="block px-4 py-2.5 text-[11px] font-bold text-gray-600 hover:bg-gray-50 hover:text-green-700 transition-colors flex items-center gap-2">
                                                <i class="fa-solid fa-comments text-emerald-700"></i>
                                                Chat with Customer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State Card details -->
                            <div id="empty_state" class="bg-white p-12 rounded-2xl border border-dashed border-gray-200 text-center select-none space-y-3">
                                <i class="fa-solid fa-calendar-days text-gray-300 text-3xl mx-auto block mb-1"></i>
                                <h4 class="font-extrabold text-sm text-gray-900">No bookings yet</h4>
                                <p class="text-[11px] text-gray-400 leading-snug">When customers purchase your services, they will appear right here.</p>
                            </div>
                        @endforelse

                        <!-- Empty search state display -->
                        <div id="empty_search_state" class="hidden bg-white p-12 rounded-2xl border border-dashed border-gray-200 text-center select-none space-y-3">
                            <i class="fa-solid fa-magnifying-glass text-gray-300 text-3xl mx-auto block mb-1"></i>
                            <h4 class="font-extrabold text-sm text-gray-900">No matching bookings</h4>
                            <p class="text-[11px] text-gray-400 leading-snug">Try adjusting your filters or search terms.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Area: Summary & Calendars (1/3 width) -->
                <div class="xl:col-span-1 space-y-6">
                    
                    <!-- Booking Summary Metrics panel -->
                    <div class="bg-white p-4.5 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-3.5">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-2 select-none">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Booking Summary</h3>
                            <span class="text-[9.5px] font-bold text-[#1B7339] bg-green-50 px-2 py-0.5 rounded-md">This Month</span>
                        </div>

                        <div class="space-y-3">
                            <!-- Metric 1: Total Bookings -->
                            <div class="flex items-center justify-between select-none">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-chart-simple text-blue-700 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9.5px] text-gray-400 font-extrabold uppercase tracking-wide leading-none">Total Bookings</p>
                                        <p class="font-extrabold text-[13px] text-gray-900 mt-1 leading-none">{{ $totalBookingsCount }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-600">↑ 18%</span>
                            </div>

                            <!-- Metric 2: Pending -->
                            <div class="flex items-center justify-between select-none">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-hourglass-half text-amber-700 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9.5px] text-gray-400 font-extrabold uppercase tracking-wide leading-none">Pending</p>
                                        <p class="font-extrabold text-[13px] text-gray-900 mt-1 leading-none">{{ $pendingCount }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-600">↑ 12%</span>
                            </div>

                            <!-- Metric 3: Completed -->
                            <div class="flex items-center justify-between select-none">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-circle-check text-emerald-700 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9.5px] text-gray-400 font-extrabold uppercase tracking-wide leading-none">Completed</p>
                                        <p class="font-extrabold text-[13px] text-gray-900 mt-1 leading-none">{{ $completedCount }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-600">↑ 20%</span>
                            </div>

                            <!-- Metric 4: Cancelled -->
                            <div class="flex items-center justify-between select-none">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-red-50 text-red-700 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-circle-xmark text-red-700 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9.5px] text-gray-400 font-extrabold uppercase tracking-wide leading-none">Cancelled</p>
                                        <p class="font-extrabold text-[13px] text-gray-900 mt-1 leading-none">{{ $cancelledCount }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-red-500">↓ 5%</span>
                             </div>
                         </div>
                     </div>

                    <!-- Dynamic Calendar Widget -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4 select-none">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-2 select-none">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Calendar</h3>
                            <span class="text-[10.5px] font-extrabold text-gray-700 select-none">{{ $monthName }}</span>
                        </div>

                        <!-- Calendar Grid structure -->
                        <div class="space-y-2">
                            <!-- Weekdays Header -->
                            <div class="grid grid-cols-7 gap-1 text-center text-[9px] font-extrabold text-gray-400 uppercase tracking-widest">
                                <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                            </div>
                            
                            <!-- Days Grid loop -->
                            <div class="grid grid-cols-7 gap-1 text-center text-[10.5px] font-bold text-gray-700">
                                <!-- Pre-month padding slots -->
                                @for ($i = 0; $i < $startOfWeek; $i++)
                                    <span class="py-2 text-gray-200"></span>
                                @endfor

                                <!-- Days of active month -->
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $dayDateStr = $now->copy()->day($day)->format('Y-m-d');
                                        $dayBookings = $bookingsByDate[$dayDateStr] ?? [];
                                        $isToday = ($day == $now->day);
                                    @endphp
                                    <div class="py-1.5 rounded-lg flex flex-col items-center justify-between h-9 transition-colors relative
                                        {{ $isToday ? 'bg-emerald-600 text-white shadow-sm' : 'hover:bg-gray-50' }}">
                                        
                                        <span class="select-none leading-none">{{ $day }}</span>
                                        
                                        <!-- Dots for active day booking status -->
                                        @if (count($dayBookings) > 0)
                                            <div class="flex items-center justify-center gap-0.5 mt-1 select-none">
                                                @foreach (array_slice($dayBookings, 0, 3) as $db)
                                                    <span class="w-1 h-1 rounded-full shrink-0 select-none
                                                        @switch($db->status)
                                                            @case('pending') bg-amber-400 @break
                                                            @case('confirmed') bg-blue-500 @break
                                                            @case('completed') bg-emerald-500 @break
                                                            @default bg-gray-400
                                                        @endswitch">
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="h-1 mt-1 select-none"></div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Legend details -->
                        <div class="flex items-center justify-center gap-3 text-[9px] font-extrabold text-gray-400 uppercase tracking-wider pt-2 border-t border-gray-50 select-none">
                            <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span> Pending</span>
                            <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Confirmed</span>
                            <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Completed</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Interactive Client side filter engine javascript -->
<script>
    let currentStatusFilter = 'all';

    function filterStatus(status, btnElement) {
        currentStatusFilter = status;
        
        // Update active class on all status buttons
        document.querySelectorAll('[id^="tab_"]').forEach(btn => {
            btn.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50";
        });
        
        // Add active color styles to clicked tab
        if (status === 'all') {
            btnElement.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-600 text-white shadow-sm border border-emerald-600";
        } else if (status === 'pending') {
            btnElement.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-amber-500 text-white shadow-sm border border-amber-500";
        } else if (status === 'confirmed') {
            btnElement.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-blue-600 text-white shadow-sm border border-blue-600";
        } else if (status === 'completed') {
            btnElement.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-700 text-white shadow-sm border border-emerald-700";
        } else if (status === 'cancelled') {
            btnElement.className = "px-4 py-2 text-xs font-bold rounded-xl transition-all bg-red-600 text-white shadow-sm border border-red-600";
        }
        
        runFilters();
    }

    function toggleDropdown(btn) {
        const parent = btn.closest('.dropdown-container');
        const menu = parent.querySelector('.dropdown-menu');
        
        // Close all other vertical menus
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) m.classList.add('hidden');
        });
        
        menu.classList.toggle('hidden');
    }

    // Close vertical menus on window click
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                m.classList.add('hidden');
            });
        }
    });

    function runFilters() {
        const query = document.getElementById('search_query').value.trim().toLowerCase();
        const serviceFilter = document.getElementById('filter_service').value;
        const sortCriteria = document.getElementById('sort_criteria').value;
        
        const listContainer = document.getElementById('bookings_list');
        const rows = Array.from(listContainer.getElementsByClassName('booking-row'));
        
        let visibleCount = 0;
        
        // Filter rows
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const serviceId = row.getAttribute('data-service-id');
            const searchableText = row.getAttribute('data-searchable');
            
            const matchStatus = (currentStatusFilter === 'all' || status === currentStatusFilter);
            const matchService = (serviceFilter === 'all' || serviceId === serviceFilter);
            const matchSearch = (query === '' || searchableText.includes(query));
            
            if (matchStatus && matchService && matchSearch) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Sort visible rows
        const sortedRows = rows.filter(row => !row.classList.contains('hidden')).sort((a, b) => {
            if (sortCriteria === 'newest') {
                return parseInt(b.getAttribute('data-timestamp')) - parseInt(a.getAttribute('data-timestamp'));
            } else if (sortCriteria === 'oldest') {
                return parseInt(a.getAttribute('data-timestamp')) - parseInt(b.getAttribute('data-timestamp'));
            } else if (sortCriteria === 'highest_price') {
                return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
            }
            return 0;
        });
        
        // Re-append sorted rows to listContainer
        sortedRows.forEach(row => {
            listContainer.appendChild(row);
        });
        
        // Toggle empty search display states
        const emptySearchState = document.getElementById('empty_search_state');
        const defaultEmptyState = document.getElementById('empty_state');
        
        if (visibleCount === 0) {
            if (rows.length > 0) {
                emptySearchState.classList.remove('hidden');
                if (defaultEmptyState) defaultEmptyState.classList.add('hidden');
            }
        } else {
            emptySearchState.classList.add('hidden');
            if (defaultEmptyState) defaultEmptyState.classList.remove('hidden');
        }
    }

    // Run filters initially on page load
    document.addEventListener('DOMContentLoaded', () => {
        runFilters();
    });
</script>
@endsection
