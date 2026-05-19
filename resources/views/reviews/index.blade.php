@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    <!-- Sidebar -->
    @include('provider-dashboard-sidebar')

    @php
        $provider = Auth::user();
        
        // Calculate aggregators
        $totalCount = count($reviews);
        $avgRating = number_format($provider->averageRating(), 1);
    @endphp

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">
            
            <!-- Title Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-[22px] font-bold text-gray-950 leading-none tracking-tight">Customer Reviews</h1>
                    <p class="text-[11.5px] text-gray-500 font-medium mt-1.5 font-bold">Monitor and manage historical ratings left by customer accounts.</p>
                </div>
            </div>

            <!-- Dashboard Review Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
                
                <!-- Left Area: Summary Board (1/4 width) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.012)] text-center space-y-4">
                        <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest leading-none">Average Score</p>
                        <p class="text-5xl font-extrabold text-gray-950 leading-none">{{ $avgRating }}</p>
                        
                        <div class="flex text-yellow-400 justify-center">
                            @php $fullStars = round($avgRating); @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-sm {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-200' }} mx-0.5"></i>
                            @endfor
                        </div>

                        <p class="text-[10px] text-gray-400 font-extrabold tracking-widest uppercase mt-2">
                            Based on {{ $totalCount }} ratings
                        </p>
                    </div>
                </div>

                <!-- Right Area: Reviews list feed (3/4 width) -->
                <div class="lg:col-span-3 space-y-4">
                    @forelse ($reviews as $review)
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.01)] hover:shadow-md transition-all space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#E2E4DE] overflow-hidden flex items-center justify-center text-gray-600 font-bold text-xs border border-gray-100 select-none">
                                        @if ($review->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($review->user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-xs text-gray-900 leading-none">{{ $review->user->name }}</p>
                                        <p class="text-[9px] text-gray-400 font-bold mt-1 uppercase tracking-wider">Customer</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="flex text-yellow-400 gap-0.5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-bold">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 font-medium leading-relaxed italic pl-1">
                                "{{ $review->comment ?? 'No written comment left.' }}"
                            </p>
                        </div>
                    @empty
                        <div class="bg-white p-16 rounded-3xl border border-dashed border-gray-200 text-center select-none shadow-[0_2px_10px_rgba(0,0,0,0.005)]">
                            <i class="fa-solid fa-star text-yellow-400 text-3xl mx-auto block mb-2"></i>
                            <h4 class="font-extrabold text-sm text-gray-900 mt-4">No reviews yet</h4>
                            <p class="text-[11px] text-gray-400 mt-1 leading-snug">When customers write reviews for your service operations, they will display here.</p>
                        </div>
                    @endforelse

                    <div class="mt-6 pt-2">
                        {{ $reviews->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
