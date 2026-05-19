@extends('layouts.app')
@section('no_container', true)

@section('content')
<div class="min-h-screen bg-[#F8F9FA] font-sans pb-20 select-none">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 space-y-8">
        
        <!-- Header Info Block -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 select-none">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-950 tracking-tight leading-none">My Bookings</h1>
                <p class="text-xs text-gray-500 font-semibold mt-2">Track, schedule, and review your eco-friendly service orders.</p>
            </div>
            <a href="{{ route('services.list') }}" class="inline-flex items-center gap-1.5 px-4.5 py-2.5 bg-[#1B7339] hover:bg-[#12472F] text-white text-xs font-extrabold rounded-xl transition-all shadow-sm select-none">
                <span>Book New Service</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
            </a>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm select-none" role="alert">
                <p class="font-bold text-xs">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Bookings Status Filter Navigation -->
        <div class="flex flex-wrap items-center gap-2 select-none border-b border-gray-150 pb-3">
            <button type="button" onclick="filterCustomerBookings('all', this)" class="cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-600 text-white shadow-sm border border-emerald-600">
                All Orders <span class="ml-1 opacity-90">{{ count($bookings) }}</span>
            </button>
            <button type="button" onclick="filterCustomerBookings('pending', this)" class="cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                Pending <span class="ml-1 bg-amber-50 text-amber-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-amber-200/50">{{ $bookings->where('status', 'pending')->count() }}</span>
            </button>
            <button type="button" onclick="filterCustomerBookings('confirmed', this)" class="cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                Confirmed <span class="ml-1 bg-blue-50 text-blue-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-blue-200/50">{{ $bookings->where('status', 'confirmed')->count() }}</span>
            </button>
            <button type="button" onclick="filterCustomerBookings('completed', this)" class="cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                Completed <span class="ml-1 bg-emerald-50 text-emerald-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-emerald-200/50">{{ $bookings->where('status', 'completed')->count() }}</span>
            </button>
            <button type="button" onclick="filterCustomerBookings('cancelled', this)" class="cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50">
                Cancelled <span class="ml-1 bg-gray-50 text-gray-500 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-gray-200/50">{{ $bookings->where('status', 'cancelled')->count() }}</span>
            </button>
        </div>

        <!-- Bookings Container Cards list -->
        <div id="customer_bookings_list" class="space-y-4">
            @forelse ($bookings as $booking)
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/40'],
                        'confirmed' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200/40'],
                        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200/40'],
                        'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-800', 'border' => 'border-red-200/40'],
                    ];
                    $config = $statusConfig[$booking->status] ?? $statusConfig['pending'];
                @endphp

                <!-- Booking item row element card -->
                <div class="cust-booking-row bg-white p-5.5 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.012)] hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-6"
                     data-status="{{ $booking->status }}">
                    
                    <!-- Left: Service Cover thumbnail & meta info -->
                    <div class="flex items-center gap-4.5">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                            @if ($booking->service->image_path)
                                <img src="{{ asset('storage/' . $booking->service->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-[#E2E4DE] flex items-center justify-center text-xl text-emerald-800 font-extrabold select-none">🌱</div>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} select-none">
                                {{ $booking->status }}
                            </span>
                            <h3 class="font-extrabold text-[14.5px] text-gray-900 leading-tight">
                                {{ $booking->service->name }}
                            </h3>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[10.5px] text-gray-400 font-bold select-none pt-0.5">
                                <span class="text-gray-500">🗓️ {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('M d, Y • h:i A') }}</span>
                                <span>•</span>
                                <span>🤝 Provider: <span class="text-gray-600">{{ $booking->provider->name }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Middle right: Price information block -->
                    <div class="shrink-0 md:text-right select-none md:pr-4">
                        <span class="text-[9.5px] text-gray-400 font-bold uppercase tracking-wider block">Price Paid</span>
                        <span class="text-lg font-extrabold text-[#1B7339] mt-1.5 block">₹{{ number_format($booking->price, 0) }}</span>
                    </div>

                    <!-- Right: Dynamic Actions block (Rate / Chat with Provider) -->
                    <div class="flex items-center gap-3 shrink-0 select-none">
                        <!-- Message Provider link -->
                        <a href="{{ route('customer.messages.show', ['receiver' => $booking->provider->id, 'booking_id' => $booking->id]) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 hover:border-[#1B7339] text-gray-500 hover:text-[#1B7339] bg-white transition-all shadow-sm select-none"
                           title="Chat with Service Provider">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </a>

                        @if ($booking->status === 'completed')
                            @if (!$booking->review)
                                <!-- slek rate button -->
                                <a href="{{ route('reviews.create', ['booking_id' => $booking->id]) }}" 
                                   class="inline-flex items-center gap-1.5 px-4.5 py-2.5 bg-[#1B7339] hover:bg-[#12472F] text-white text-xs font-extrabold rounded-xl transition-all shadow-sm select-none">
                                    <span>Rate Service</span>
                                    <span>★</span>
                                </a>
                            @else
                                <!-- Already rated capsule -->
                                <div class="px-3.5 py-2 bg-yellow-50/50 border border-yellow-100 rounded-xl flex items-center gap-1 select-none text-[11px] font-extrabold text-yellow-700">
                                    <span>★</span>
                                    <span>Rated ({{ $booking->review->rating }} / 5)</span>
                                </div>
                            @endif
                        @else
                            <button type="button" disabled class="px-4.5 py-2.5 bg-gray-50 border border-gray-150 text-gray-400 text-xs font-extrabold rounded-xl select-none">
                                Active Order
                            </button>
                        @endif
                    </div>

                </div>
            @empty
                <!-- Default organic empty state -->
                <div id="customer_empty_state" class="bg-white p-16 rounded-3xl border border-dashed border-gray-200 text-center select-none shadow-[0_2px_10px_rgba(0,0,0,0.005)]">
                    <span class="text-4xl">♻️</span>
                    <h4 class="font-extrabold text-sm text-gray-900 mt-4">No waste pickup orders yet</h4>
                    <p class="text-[11px] text-gray-400 mt-1 leading-snug">Book your first sustainable waste processing service to clean up the environment!</p>
                    <a href="{{ route('services.list') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-[#1B7339] hover:bg-[#12472F] text-white text-xs font-extrabold rounded-xl transition-all shadow-sm mt-6 select-none">
                        Browse Eco Services
                    </a>
                </div>
            @endforelse

            <!-- Dynamic empty tab search status display -->
            <div id="customer_empty_filter_state" class="hidden bg-white p-16 rounded-3xl border border-dashed border-gray-200 text-center select-none">
                <span class="text-3xl">🔍</span>
                <h4 class="font-extrabold text-sm text-gray-900 mt-4">No matching orders</h4>
                <p class="text-[11px] text-gray-400 mt-1 leading-snug">There are no orders with this status at the moment.</p>
            </div>
        </div>

    </div>
</div>

<!-- Simple and ultra fast dynamic tab filter script -->
<script>
    function filterCustomerBookings(status, tabButton) {
        // Remove active colors from all tab navigation items
        document.querySelectorAll('.cust-tab-btn').forEach(btn => {
            btn.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-white border border-gray-200 text-gray-600 hover:bg-gray-50";
        });

        // Set active color style to clicked button
        if (status === 'all') {
            tabButton.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-600 text-white shadow-sm border border-emerald-600";
        } else if (status === 'pending') {
            tabButton.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-amber-500 text-white shadow-sm border border-amber-500";
        } else if (status === 'confirmed') {
            tabButton.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-blue-600 text-white shadow-sm border border-blue-600";
        } else if (status === 'completed') {
            tabButton.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-emerald-700 text-white shadow-sm border border-emerald-700";
        } else if (status === 'cancelled') {
            tabButton.className = "cust-tab-btn px-4 py-2 text-xs font-bold rounded-xl transition-all bg-red-600 text-white shadow-sm border border-red-600";
        }

        const rows = Array.from(document.getElementsByClassName('cust-booking-row'));
        let count = 0;

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'all' || rowStatus === status) {
                row.classList.remove('hidden');
                count++;
            } else {
                row.classList.add('hidden');
            }
        });

        const emptyFilterState = document.getElementById('customer_empty_filter_state');
        const defaultEmptyState = document.getElementById('customer_empty_state');

        if (count === 0) {
            if (rows.length > 0) {
                emptyFilterState.classList.remove('hidden');
                if (defaultEmptyState) defaultEmptyState.classList.add('hidden');
            }
        } else {
            emptyFilterState.classList.add('hidden');
            if (defaultEmptyState) defaultEmptyState.classList.remove('hidden');
        }
    }
</script>
@endsection
