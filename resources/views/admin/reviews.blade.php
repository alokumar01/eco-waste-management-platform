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
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Customer Reviews</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Monitor user feedback and moderate comments across all services.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reviews Listing -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">All Service Reviews</h3>
                    <span class="text-xs bg-[#E8F5E9] text-[#2E6F40] font-bold px-2.5 py-1 rounded-full">{{ $reviews->count() }} Reviews</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($reviews as $review)
                        <div class="p-6 flex flex-col md:flex-row md:items-start md:justify-between gap-6 hover:bg-[#FAFCFB] transition-colors">
                            <div class="space-y-3 flex-1">
                                <!-- Reviewer & Stars -->
                                <div class="flex items-center flex-wrap gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 font-bold text-gray-700 flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-gray-900 text-xs leading-none">{{ $review->user->name ?? 'Anonymous User' }}</h4>
                                        <p class="text-[10px] text-gray-400 font-medium mt-1">Reviewed <span class="text-gray-600 font-bold">{{ $review->provider->business_name ?? 'Service Provider' }}</span></p>
                                    </div>
                                    <div class="flex items-center gap-0.5 text-amber-400 ml-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Review Comment -->
                                <p class="text-xs text-gray-600 font-medium leading-relaxed bg-gray-50/50 p-3.5 rounded-xl border border-gray-100 max-w-2xl">
                                    {{ $review->comment }}
                                </p>

                                <div class="text-[10px] text-gray-400 font-bold">
                                    Date: {{ $review->created_at->format('M d, Y \a\t h:i A') }}
                                </div>
                            </div>

                            <!-- Moderation Action -->
                            <div class="shrink-0">
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" data-confirm="Are you sure you want to delete this review?" data-confirm-title="Delete Review" data-confirm-text="Delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                        Delete Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-sm font-semibold text-gray-400">No reviews found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
