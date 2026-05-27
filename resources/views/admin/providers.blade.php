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
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Service Providers</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Review registrations, verify credentials, and manage provider status.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Providers Grid/List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">All Registered Providers</h3>
                    <span class="text-xs bg-[#E8F5E9] text-[#2E6F40] font-bold px-2.5 py-1 rounded-full">{{ $providers->count() }} Total</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($providers as $provider)
                        <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 hover:bg-[#FAFCFB] transition-colors">
                            <!-- Left: Provider Profile Details -->
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-[#E8F5E9] text-[#2E6F40] font-black text-lg flex items-center justify-center shrink-0 border border-green-50">
                                    {{ strtoupper(substr($provider->business_name ?? $provider->name, 0, 1)) }}
                                </div>
                                <div class="space-y-1.5 max-w-xl">
                                    <div class="flex items-center flex-wrap gap-2.5">
                                        <h4 class="font-extrabold text-gray-900 text-base leading-snug">{{ $provider->business_name ?? 'Unnamed Business' }}</h4>
                                        @if($provider->is_verified)
                                            <span class="inline-flex items-center gap-1 bg-[#E8F5E9] text-[#2E6F40] text-[10px] font-extrabold px-2.5 py-0.5 rounded-full select-none">
                                                <i class="fa-solid fa-circle-check"></i> Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full select-none">
                                                <i class="fa-solid fa-clock"></i> Pending Verification
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 font-bold">Owner: <span class="text-gray-600 font-semibold">{{ $provider->name }}</span></p>
                                    @if($provider->bio)
                                        <p class="text-xs text-gray-500 font-medium leading-relaxed italic">"{{ $provider->bio }}"</p>
                                    @endif
                                    <div class="flex flex-wrap gap-x-4 gap-y-1.5 text-[11px] text-gray-400 font-semibold pt-1">
                                        <span><i class="fa-solid fa-location-dot text-gray-400 mr-1"></i>{{ $provider->city ?? 'Unknown City' }}, {{ $provider->state ?? 'Unknown State' }}</span>
                                        <span><i class="fa-solid fa-envelope text-gray-400 mr-1"></i>{{ $provider->email }}</span>
                                        <span><i class="fa-solid fa-phone text-gray-400 mr-1"></i>{{ $provider->phone_number ?? 'No Phone' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Documents & Moderation Actions -->
                            <div class="flex items-center gap-3 shrink-0 lg:self-center">
                                @if($provider->verification_document)
                                    <a href="{{ asset('storage/' . $provider->verification_document) }}" target="_blank"
                                       class="px-4 py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-file-pdf"></i> View Documents
                                    </a>
                                @endif

                                @if(!$provider->is_verified)
                                    <form method="POST" action="{{ route('admin.verifyProvider', $provider->id) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-[#1A4D2E] hover:bg-green-900 text-white text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Verify & Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.declineProvider', $provider->id) }}" data-confirm="Are you sure you want to decline this registration?" data-confirm-title="Decline Registration" data-confirm-text="Decline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Decline
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.declineProvider', $provider->id) }}" data-confirm="Suspend this provider and remove their services?" data-confirm-title="Suspend Provider" data-confirm-text="Suspend">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Decline / Suspend
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-sm font-semibold text-gray-400">No registered providers found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
