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
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Financial Transactions Ledger</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Audit payments, payouts, refunds, and general platform revenue metrics.</p>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">All Financial Transactions</h3>
                    <span class="text-xs bg-[#E8F5E9] text-[#2E6F40] font-bold px-2.5 py-1 rounded-full">{{ $transactions->count() }} Total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-50 text-[10px] text-gray-400 font-bold uppercase tracking-wider bg-gray-50/50">
                                <th class="px-6 py-3.5">Transaction Ref</th>
                                <th class="px-6 py-3.5">Booking ID</th>
                                <th class="px-6 py-3.5">Customer</th>
                                <th class="px-6 py-3.5">Provider</th>
                                <th class="px-6 py-3.5">Paid On</th>
                                <th class="px-6 py-3.5">Amount</th>
                                <th class="px-6 py-3.5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-[12px] text-gray-700">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-[#FAFCFB] transition-colors">
                                    <td class="px-6 py-4 font-extrabold text-gray-900">
                                        #TXN-{{ strtoupper(substr($transaction->payment_gateway_ref, 0, 8)) ?: str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-400">
                                        @if($transaction->booking)
                                            #GL-{{ str_pad($transaction->booking_id, 5, '0', STR_PAD_LEFT) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($transaction->booking && $transaction->booking->customer)
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full bg-[#E3F2FD] text-[#1565C0] font-black text-[11px] flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($transaction->booking->customer->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-extrabold text-gray-900 leading-snug">{{ $transaction->booking->customer->name }}</h4>
                                                    <p class="text-[10px] text-gray-400 font-semibold">{{ $transaction->booking->customer->email }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Unknown Customer</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($transaction->booking && $transaction->booking->provider)
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full bg-[#EAF5EE] text-[#3E8B3A] font-black text-[11px] flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($transaction->booking->provider->business_name ?? 'Prov', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-extrabold text-gray-900 leading-snug">{{ $transaction->booking->provider->business_name ?? 'Provider' }}</h4>
                                                    <p class="text-[10px] text-gray-400 font-semibold">{{ $transaction->booking->provider->email }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Unknown Provider</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 font-medium">
                                        {{ is_string($transaction->created_at) ? $transaction->created_at : $transaction->created_at->format('M d, Y • h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 font-extrabold text-[#3E8B3A]">
                                        +₹{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($transaction->status === 'completed' || $transaction->status === 'paid' || $transaction->status === 'paid_out')
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#E8F5E9] text-[#2E6F40]">Paid</span>
                                        @elseif($transaction->status === 'refunded')
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFEBEE] text-[#C62828]">Refunded</span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-[#FFF3E0] text-[#E65100]">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium italic">
                                        No financial transactions found on the platform.
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
