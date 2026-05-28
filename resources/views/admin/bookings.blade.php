@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#FAFCFB] font-sans overflow-hidden">
    @include('admin-dashboard-sidebar')

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('admin-dashboard-header')

        <!-- Scrollable content -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#FAFCFB] space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">All Platform Bookings</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Monitor, review, and track all waste management bookings scheduled on GreenLoop.</p>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">Bookings Ledger</h3>
                    <span class="text-xs bg-[#E8F5E9] text-[#2E6F40] font-bold px-2.5 py-1 rounded-full">{{ $bookings->count() }} Total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider bg-gray-50/50">
                                <th class="px-6 py-3.5">Booking ID</th>
                                <th class="px-6 py-3.5">Customer</th>
                                <th class="px-6 py-3.5">Provider</th>
                                <th class="px-6 py-3.5">Service Details</th>
                                <th class="px-6 py-3.5">Scheduled On</th>
                                <th class="px-6 py-3.5">Price</th>
                                <th class="px-6 py-3.5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-[12px] text-gray-700">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-[#FAFCFB] transition-colors">
                                    <td class="px-6 py-4 font-extrabold text-gray-900">
                                        #GL-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-full bg-[#E3F2FD] text-[#1565C0] font-black text-[11px] flex items-center justify-center shrink-0">
                                                {{ strtoupper(substr($booking->customer->name ?? 'Cust', 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-gray-900 leading-snug">{{ $booking->customer->name ?? 'Customer' }}</h4>
                                                <p class="text-[10px] text-gray-400 font-semibold">{{ $booking->customer->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-full bg-[#EAF5EE] text-[#3E8B3A] font-black text-[11px] flex items-center justify-center shrink-0">
                                                {{ strtoupper(substr($booking->provider->business_name ?? 'Prov', 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-gray-900 leading-snug">{{ $booking->provider->business_name ?? 'Provider' }}</h4>
                                                <p class="text-[10px] text-gray-400 font-semibold">{{ $booking->provider->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <h4 class="font-extrabold text-gray-900 leading-snug">{{ $booking->service->name ?? 'Service' }}</h4>
                                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mt-0.5">{{ $booking->service->category ?? 'General' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 font-medium">
                                        {{ is_string($booking->scheduled_at) ? $booking->scheduled_at : $booking->scheduled_at->format('M d, Y • h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-950">
                                        ₹{{ number_format($booking->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($booking->status === 'completed')
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#E8F5E9] text-[#2E6F40]">Completed</span>
                                        @elseif($booking->status === 'confirmed' || $booking->status === 'accepted')
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#E3F2FD] text-[#1565C0]">Confirmed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFEBEE] text-[#C62828]">Cancelled</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFF3E0] text-[#E65100]">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium italic">
                                        No bookings found on the platform.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
