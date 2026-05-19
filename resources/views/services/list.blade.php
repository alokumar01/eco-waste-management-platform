@extends('layouts.app')

@section('content')
    <div class="py-4 select-none">
        
        <!-- Header Panel with Premium Eco Accents -->
        <div class="mb-8">
            <h1 class="text-3xl font-heading font-extrabold text-[#0E2415] tracking-tight sm:text-4xl">Available Composting Services</h1>
            <p class="mt-2 text-sm text-gray-500 font-medium">Browse active composting and waste recycling services in your local community.</p>
        </div>

        <!-- Glassmorphic Search & Filter Bar -->
        <div class="bg-white border border-[#E3F2E6] p-4 rounded-2xl shadow-[0_4px_25px_rgba(45,106,79,0.02)] mb-8">
            <form action="{{ route('services.list') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-1 group">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#609953] transition-colors z-10">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services (e.g. food waste, plastic)..." class="block w-full h-11 pl-10 pr-4 border border-[#D2E3D6] rounded-xl text-xs bg-[#FCFDFD] focus:bg-white placeholder-gray-400 font-medium focus:border-[#609953] focus:ring-1 focus:ring-[#609953] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                </div>

                <!-- City Input -->
                <div class="relative w-full lg:w-[260px] group">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#609953] transition-colors z-10">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by City..." class="block w-full h-11 pl-10 pr-4 border border-[#D2E3D6] rounded-xl text-xs bg-[#FCFDFD] focus:bg-white placeholder-gray-400 font-medium focus:border-[#609953] focus:ring-1 focus:ring-[#609953] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                </div>

                <!-- Action Triggers -->
                <div class="flex items-center gap-2 w-full lg:w-auto shrink-0">
                    <button type="submit" class="flex-1 lg:flex-none h-11 px-6 bg-[#609953] hover:bg-[#4F7F44] text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow active:scale-[0.98] select-none flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search
                    </button>
                    
                    @if(request()->hasAny(['search', 'city']))
                        <a href="{{ route('services.list') }}" class="h-11 px-4 border border-gray-200 hover:border-red-200 text-gray-500 hover:text-red-600 rounded-xl text-xs font-bold uppercase tracking-wider transition-all select-none flex items-center justify-center gap-1 bg-white shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Premium Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(45,106,79,0.02)] border border-[#E3F2E6] overflow-hidden hover:shadow-[0_10px_30px_rgba(45,106,79,0.06)] hover:border-[#C1E1C9] transition-all duration-300 flex flex-col h-full group">
                    
                    <!-- Cover Image / Fallback -->
                    <div class="h-48 w-full relative overflow-hidden bg-gray-100 shrink-0 select-none">
                        @if ($service->image_path)
                            <img src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $service->name }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#E2E4DE] to-[#C2C9BD] flex flex-col items-center justify-center relative select-none">
                                <svg class="w-12 h-12 text-[#609953]/60 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3c4 0 7 3 7 7v4c0 3-3 5-7 5s-7-2-7-5v-4c0-4 3-7 7-7z" />
                                </svg>
                                <span class="text-[10px] font-bold text-gray-500 tracking-widest uppercase">GreenLoop</span>
                            </div>
                        @endif

                        <!-- Category Tag Overlay -->
                        <span class="absolute top-3 left-3 bg-[#609953]/90 backdrop-blur-sm text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm z-10">
                            {{ $service->category ?? 'Compost' }}
                        </span>

                        <!-- Price Pill Overlay -->
                        <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm text-[#0E2415] text-[11px] font-bold px-3 py-1 rounded-xl shadow-sm z-10 border border-[#E3F2E6]">
                            ₹{{ number_format($service->price, 0) }}<span class="text-[9px] text-gray-500 font-medium">/{{ $service->unit ?? 'kg' }}</span>
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex flex-col flex-1">
                        <div class="mb-3">
                            <h5 class="text-base font-bold text-[#0E2415] group-hover:text-[#609953] transition-colors leading-tight line-clamp-1">{{ $service->name }}</h5>
                        </div>
                        
                        <p class="text-xs text-gray-500 font-medium leading-relaxed mb-5 flex-1 line-clamp-2">
                            {{ $service->description }}
                        </p>
                        
                        <!-- Separator -->
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between gap-3">
                                <!-- Provider Details -->
                                <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                    <!-- Initial Badge -->
                                    <div class="w-9 h-9 rounded-xl bg-[#E2E4DE]/60 flex items-center justify-center text-[#609953] font-bold text-xs shrink-0 select-none border border-[#E2E4DE]/20">
                                        {{ substr($service->user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-[#0E2415] truncate">{{ $service->user->business_name ?? $service->user->name }}</p>
                                        
                                        <div class="flex items-center gap-2 mt-0.5 select-none">
                                            <!-- Stars -->
                                            @php $rating = round($service->user->averageRating()); @endphp
                                            <div class="flex text-yellow-400 shrink-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-2.5 h-2.5 {{ $i <= $rating ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-[9px] text-gray-400 font-bold">({{ $service->user->reviewCount() }})</span>
                                        </div>

                                        <p class="text-[10px] text-gray-400 font-medium flex items-center gap-1 mt-1 truncate">
                                            <svg class="w-3 h-3 text-[#609953] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $service->user->city }}, {{ $service->user->state }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Action CTA -->
                                <a href="{{ route('bookings.create', $service) }}" class="h-9 px-4 bg-[#609953] hover:bg-[#4F7F44] text-white rounded-xl text-[10px] font-bold uppercase tracking-wider transition-all select-none flex items-center justify-center shadow-sm hover:shadow active:scale-[0.98]">
                                    Book Now
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-[#C1E1C9] select-none">
                    <svg class="mx-auto h-12 w-12 text-[#609953]/50 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h4 class="text-base font-bold text-[#0E2415]">No services found</h4>
                    <p class="text-xs text-gray-400 mt-1">Try refining your search query or removing location filters.</p>
                    <a href="{{ route('services.list') }}" class="text-[#609953] font-bold text-xs mt-4 inline-block hover:underline">View all services</a>
                </div>
            @endforelse
        </div>

    </div>
@endsection