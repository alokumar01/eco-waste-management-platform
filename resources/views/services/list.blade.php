@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('content')
<!-- Import premium Google Font for unmatched visual aesthetics -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');
    
    .greenloop-directory {
        font-family: 'PT Sans', sans-serif !important;
    }
    
    /* Elegant glassmorphic filter styling */
    .filter-card {
        background: #ffffff;
        border: 1px solid #E8F2EC;
        box-shadow: 0 4px 20px rgba(26, 77, 46, 0.02);
    }
    
    /* Styled custom radio/checkbox colors */
    .custom-input:checked {
        background-color: #2E6F40 !important;
        border-color: #2E6F40 !important;
    }
    
    /* Category item active state */
    .category-item.active {
        background-color: #E8F5E9 !important;
        color: #2E6F40 !important;
        font-weight: 700 !important;
    }
</style>

<div class="greenloop-directory py-6 select-none bg-[#FAFCFB] min-h-screen px-4 sm:px-6 lg:px-8">
    <div class="max-w-[1400px] mx-auto">
        
        <form id="filters_form" action="{{ route('services.list') }}" method="GET" class="space-y-6">
            <!-- Hidden parameters for persistent state -->
            <input type="hidden" name="category" id="category_input" value="{{ request('category', 'All Categories') }}">
            <input type="hidden" name="verified" id="verified_input" value="{{ request('verified', '0') }}">
            <input type="hidden" name="top_rated" id="top_rated_input" value="{{ request('top_rated', '0') }}">
            
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- 1. LEFT SIDEBAR: Filters Panel -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="filter-card rounded-2xl p-5 space-y-6 relative overflow-hidden">
                        @guest
                            <!-- Beautiful glassmorphic lock overlay -->
                            <div class="absolute inset-0 bg-white/75 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center p-4 text-center select-none animate-in fade-in duration-300">
                                <div class="w-10 h-10 rounded-full bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center mb-2 shadow-sm border border-[#C1E1C9]/50">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <h4 class="text-xs font-bold text-gray-900">Filters Locked</h4>
                                <p class="text-[9.5px] text-gray-500 mt-1 max-w-[170px] leading-relaxed font-semibold">Please log in to access search filters and categories.</p>
                                <a href="{{ route('login') }}" class="mt-3.5 px-4 py-1.5 bg-[#2E6F40] hover:bg-green-800 text-white text-[10px] font-bold rounded-lg shadow-sm transition-all cursor-pointer text-center">
                                    Log In to Access
                                </a>
                            </div>
                        @endguest
                        
                        <div class="space-y-6 @guest filter blur-[0.5px] pointer-events-none @endguest">
                            <!-- Header row -->
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <span class="text-xs font-bold text-gray-900 tracking-wider uppercase">Filters</span>
                            <a href="{{ route('services.list') }}" class="text-[11px] font-bold text-[#2E6F40] hover:text-green-800 flex items-center gap-1">
                                <i class="fa-solid fa-rotate-left text-[9px]"></i> Reset
                            </a>
                        </div>
                        
                        <!-- Service Category Accordion -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Service Category</span>
                                <i class="fa-solid fa-chevron-up text-[9px] text-gray-400"></i>
                            </div>
                            <div class="space-y-1">
                                @foreach($categoriesList as $name => $count)
                                    @php
                                        $isActive = request('category', 'All Categories') === $name;
                                    @endphp
                                    <button type="button" onclick="selectCategory('{{ $name }}')" class="category-item w-full flex items-center justify-between px-3 py-2 rounded-xl text-left text-xs font-medium text-gray-600 hover:bg-gray-50 transition-all cursor-pointer {{ $isActive ? 'active' : '' }}">
                                        <div class="flex items-center gap-2">
                                            @if($name == 'All Categories')
                                                <i class="fa-solid fa-leaf text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Composting')
                                                <i class="fa-solid fa-leaf text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Recycling')
                                                <i class="fa-solid fa-recycle text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'E-Waste')
                                                <i class="fa-solid fa-plug text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Organic Waste')
                                                <i class="fa-solid fa-apple-whole text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Garden Waste')
                                                <i class="fa-solid fa-seedling text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @else
                                                <i class="fa-solid fa-building text-[11px] {{ $isActive ? 'text-[#2E6F40]' : 'text-gray-400' }}"></i>
                                            @endif
                                            <span>{{ $name }}</span>
                                        </div>
                                        <span class="text-[9.5px] font-bold {{ $isActive ? 'bg-[#2E6F40] text-white' : 'bg-gray-100 text-gray-400' }} px-1.5 py-0.5 rounded-full">{{ $count }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Service Type Accordion -->
                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Service Type</span>
                                <i class="fa-solid fa-chevron-up text-[9px] text-gray-400"></i>
                            </div>
                            <div class="space-y-2.5">
                                @foreach($typeCounts as $type => $count)
                                    @php
                                        $checked = is_array(request('service_type')) ? in_array($type, request('service_type')) : request('service_type') === $type;
                                    @endphp
                                    <label class="flex items-center justify-between text-xs font-semibold text-gray-600 cursor-pointer group">
                                        <div class="flex items-center gap-2.5">
                                            <input type="checkbox" name="service_type[]" value="{{ $type }}" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 rounded text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $checked ? 'checked' : '' }}>
                                            <span>{{ $type }}</span>
                                        </div>
                                        <span class="text-[9.5px] font-bold text-gray-400">{{ $count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Price Range Accordion -->
                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Price Range</span>
                                <i class="fa-solid fa-chevron-up text-[9px] text-gray-400"></i>
                            </div>
                            <div class="space-y-2.5">
                                @php
                                    $priceRange = request('price_range');
                                @endphp
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ !$priceRange ? 'checked' : '' }}>
                                    <span>All Prices</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="under-200" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $priceRange === 'under-200' ? 'checked' : '' }}>
                                    <span>Under <span style="font-family: system-ui, sans-serif !important;">₹</span>200</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="200-500" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $priceRange === '200-500' ? 'checked' : '' }}>
                                    <span><span style="font-family: system-ui, sans-serif !important;">₹</span>200 - <span style="font-family: system-ui, sans-serif !important;">₹</span>500</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="500-1000" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $priceRange === '500-1000' ? 'checked' : '' }}>
                                    <span><span style="font-family: system-ui, sans-serif !important;">₹</span>500 - <span style="font-family: system-ui, sans-serif !important;">₹</span>1000</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="above-1000" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $priceRange === 'above-1000' ? 'checked' : '' }}>
                                    <span>Above <span style="font-family: system-ui, sans-serif !important;">₹</span>1000</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Rating Accordion -->
                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Rating</span>
                                <i class="fa-solid fa-chevron-up text-[9px] text-gray-400"></i>
                            </div>
                            <div class="space-y-2.5">
                                @php
                                    $ratingVal = request('rating');
                                @endphp
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="rating" value="" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ !$ratingVal ? 'checked' : '' }}>
                                    <span>All Ratings</span>
                                </label>
                                @foreach([4, 3, 2, 1] as $stars)
                                    <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $stars }}" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#2E6F40] border-gray-300 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $ratingVal == $stars ? 'checked' : '' }}>
                                        <div class="flex items-center gap-1">
                                            <div class="flex text-amber-400 gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star text-[9.5px] {{ $i <= $stars ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-[10px] text-gray-400 ml-1">& above</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        </div>
                    </div>
                </div>

                <!-- 2. RIGHT CONTENT: Services Catalog display -->
                <div class="lg:col-span-9 space-y-6 mt-6 lg:mt-0">
                    
                    <!-- Search Bar Panel (mockup design, no outer wrapper) -->
                    <div class="flex flex-col md:flex-row gap-3">
                        <!-- Search services input -->
                        <div class="relative flex-1 group">
                            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#2E6F40] transition-colors z-10">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services (e.g. food waste, composting, e-waste)..." class="block w-full h-11 pl-10 pr-4 border border-gray-200 rounded-xl text-xs bg-white focus:bg-white placeholder-gray-400 font-medium focus:border-[#2E6F40] focus:ring-1 focus:ring-[#2E6F40] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                        </div>

                        <!-- Filter by City input -->
                        <div class="relative w-full md:w-[220px] group">
                            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#2E6F40] transition-colors z-10">
                                <i class="fa-solid fa-location-dot text-sm"></i>
                            </span>
                            <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by City" class="block w-full h-11 pl-10 pr-4 border border-gray-200 rounded-xl text-xs bg-white focus:bg-white placeholder-gray-400 font-medium focus:border-[#2E6F40] focus:ring-1 focus:ring-[#2E6F40] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                        </div>

                        <!-- Search Button -->
                        <div class="shrink-0 w-full md:w-auto">
                            <button type="submit" class="w-full md:w-auto h-11 px-6 bg-[#2E6F40] hover:bg-green-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                Search
                            </button>
                        </div>
                    </div>

                    <!-- Section Title & Description -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 select-none">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 tracking-tight">All Services</h2>
                            <p class="text-xs text-gray-500 font-semibold mt-1">Find the best waste management and composting services near you.</p>
                        </div>
                    </div>
                    
                    <!-- Segmented Pills Controls Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <!-- Pills -->
                        <div class="flex flex-wrap items-center gap-2">
                            @php
                                $isTopRatedTab = request('top_rated') == '1';
                                $isAllTab = !$isTopRatedTab;
                            @endphp
                            
                            <!-- All Services Tab -->
                            <button type="button" onclick="selectTab('all')" class="segment-pill text-xs font-bold px-4 py-2 rounded-full cursor-pointer transition-all select-none border {{ $isAllTab ? 'bg-[#E8F5E9] text-[#2E6F40] border-[#C1E1C9]' : 'bg-white hover:bg-gray-50 text-gray-600 border-gray-200' }}">
                                <i class="fa-solid fa-leaf mr-1 text-[10px]"></i> All Services 
                                <span class="ml-1 text-[9.5px] px-1.5 py-0.2 rounded-full {{ $isAllTab ? 'bg-[#2E6F40] text-white' : 'bg-gray-100 text-gray-400' }}">{{ $services->count() }}</span>
                            </button>
                            
                            <!-- Top Rated Tab -->
                            <button type="button" onclick="selectTab('top_rated')" class="segment-pill text-xs font-bold px-4 py-2 rounded-full cursor-pointer transition-all select-none border {{ $isTopRatedTab ? 'bg-[#E8F5E9] text-[#2E6F40] border-[#C1E1C9]' : 'bg-white hover:bg-gray-50 text-gray-600 border-gray-200' }}">
                                <i class="fa-solid fa-star mr-1 text-[10px]"></i> Top Rated
                            </button>
                            
                            <!-- Most Booked Tab -->
                            <button type="button" class="segment-pill text-xs font-bold px-4 py-2 rounded-full cursor-pointer transition-all select-none border bg-white hover:bg-gray-50 text-gray-600 border-gray-200">
                                <i class="fa-solid fa-fire mr-1 text-[10px]"></i> Most Booked
                            </button>
                        </div>
                        
                        <!-- Sort by selector -->
                        <div class="flex items-center gap-2 select-none">
                            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider shrink-0">Sort by:</span>
                            <select name="sort_by" onchange="document.getElementById('filters_form').submit()" class="text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-xl px-3 py-1.5 focus:ring-0 focus:border-[#2E6F40] cursor-pointer">
                                <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="price-low" {{ request('sort_by') == 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price-high" {{ request('sort_by') == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                            </select>
                        </div>
                    </div>

                    <!-- Services Dynamic Grid (4 Columns as Mockup) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse ($services as $service)
                            @php
                                $imgPath = null;
                                if ($service->image_path) {
                                    if (str_starts_with($service->image_path, '[')) {
                                        $images = json_decode($service->image_path, true);
                                        $imgPath = !empty($images) ? $images[0] : null;
                                    } else {
                                        $imgPath = $service->image_path;
                                    }
                                }
                            @endphp
                            
                            <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden hover:shadow-[0_12px_28px_rgba(45,106,79,0.045)] hover:border-[#C1E1C9] transition-all duration-300 flex flex-col group relative">
                                
                                <!-- Cover Image or premium fallbacks -->
                                <div class="h-40 w-full relative overflow-hidden bg-gray-50 shrink-0 select-none">
                                    <a href="{{ Auth::check() ? route('bookings.create', $service) : route('login') }}" class="block w-full h-full">
                                        @if ($imgPath)
                                            <img src="{{ asset('storage/' . $imgPath) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $service->name }}">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-[#E2E8E4] to-[#B8C8BD] flex flex-col items-center justify-center relative select-none">
                                                <i class="fa-solid fa-leaf text-[#2E6F40]/40 text-3xl mb-1"></i>
                                                <span class="text-[8px] font-extrabold text-[#2E6F40]/60 tracking-widest uppercase">GreenLoop</span>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Category Tag Overlay -->
                                    <span class="absolute top-3 left-3 bg-[#2E6F40] text-white text-[8px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider z-10 shadow-sm">
                                        {{ strtoupper($service->category ?? 'Composting') }}
                                    </span>

                                    <!-- Price Pill Overlay -->
                                    <span class="absolute top-3 right-3 bg-white text-gray-900 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-gray-100 shadow-sm z-10">
                                        <span style="font-family: system-ui, sans-serif !important;">₹</span>{{ number_format($service->price, 0) }}<span class="text-[8.5px] text-gray-400 font-semibold">/{{ $service->unit ?? 'kg' }}</span>
                                    </span>
                                    
                                    @guest
                                        <!-- Lock badge to indicate login is required for guest users -->
                                        <a href="{{ route('login') }}" class="absolute top-10 right-3 bg-red-50/95 backdrop-blur-sm text-red-700 text-[8px] font-extrabold px-1.5 py-0.5 rounded border border-red-100 shadow-sm z-10 flex items-center gap-0.5 cursor-pointer hover:bg-red-100 transition-colors">
                                            <i class="fa-solid fa-lock text-[7px]"></i> Log In to view details
                                        </a>
                                    @endguest
                                </div>

                                <!-- Card details body -->
                                <div class="p-3.5 flex flex-col flex-1">
                                    <h3 class="text-xs font-bold text-gray-900 leading-snug line-clamp-1 mb-1">
                                        <a href="{{ Auth::check() ? route('bookings.create', $service) : route('login') }}" class="hover:text-[#2E6F40] transition-colors">{{ $service->name }}</a>
                                    </h3>
                                    
                                    <p class="text-[10px] text-gray-500 font-medium leading-relaxed mb-3 line-clamp-2">
                                        {{ $service->description }}
                                    </p>
                                    
                                    <!-- Provider details row -->
                                    <div class="flex items-center gap-2 mb-3 select-none">
                                        <!-- Avatar image -->
                                        <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($service->user->name) . '&background=E8F5E9&color=1B7339' }}" class="w-8 h-8 rounded-full object-cover border border-gray-100 shrink-0">
                                        
                                        <div class="min-w-0 flex-1">
                                            <!-- Provider business name with Verified badges -->
                                            <div class="flex items-center gap-1.5 min-w-0">
                                                <span class="text-[10px] font-extrabold text-gray-900 truncate">{{ $service->user->business_name ?? $service->user->name }}</span>
                                                @if($service->user->verification_document || $service->user->is_verified)
                                                    <span class="inline-flex items-center gap-0.5 px-1 py-0.2 rounded-full bg-[#E8F5E9] text-[#2E6F40] text-[7.5px] font-extrabold leading-none shrink-0 scale-90">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Verified
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Stars / Rating / Location row -->
                                            <div class="flex items-center gap-1 leading-none mt-0.5">
                                                <i class="fa-solid fa-star text-amber-500 text-[9px]"></i>
                                                <span class="text-[9px] text-gray-900 font-bold">{{ number_format($service->user->averageRating() ?: 4.8, 1) }}</span>
                                                <span class="text-[8.5px] text-gray-400 font-medium">({{ $service->user->reviewCount() ?: 32 }} reviews)</span>
                                            </div>
                                            
                                            <!-- Neighborhood/Location -->
                                            <div class="flex items-center gap-0.5 text-[8.5px] text-gray-400 font-bold mt-0.5 truncate">
                                                <i class="fa-solid fa-location-dot text-gray-400/80 text-[8px] shrink-0"></i>
                                                @php
                                                    $locationStr = $service->user->city ?? 'Bengaluru';
                                                    if ($service->user->business_address) {
                                                        $parts = array_map('trim', explode(',', $service->user->business_address));
                                                        if (count($parts) > 1) {
                                                            $locationStr = $parts[0] . ', ' . ($service->user->city ?? 'Bengaluru');
                                                        } else {
                                                            $locationStr = $parts[0];
                                                        }
                                                    }
                                                @endphp
                                                <span>{{ $locationStr }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bottom meta tags & Book Now row -->
                                    <div class="border-t border-gray-100 pt-2.5 flex items-center justify-between gap-2 mt-auto">
                                        <div class="text-[8px] text-gray-400 font-bold select-none shrink min-w-0">
                                            <span class="flex items-center gap-1 truncate uppercase">
                                                @if(strtolower($service->type) == 'pickup' || strtolower($service->type) == 'pickup service')
                                                    <i class="fa-solid fa-truck text-[#2E6F40]/60 text-[9px] shrink-0"></i>
                                                @elseif(strtolower($service->type) == 'on-site' || strtolower($service->type) == 'on-site service' || strtolower($service->type) == 'onsite')
                                                    <i class="fa-solid fa-house-chimney text-[#2E6F40]/60 text-[9px] shrink-0"></i>
                                                @else
                                                    <i class="fa-solid fa-comments text-[#2E6F40]/60 text-[9px] shrink-0"></i>
                                                @endif
                                                {{ $service->type ?? 'Pickup Service' }}
                                            </span>
                                        </div>
                                        
                                        @guest
                                            <a href="{{ route('login') }}" class="px-2.5 py-1.5 text-white font-extrabold text-[9px] rounded-lg tracking-wider uppercase transition-all select-none hover:bg-green-800 flex items-center justify-center shrink-0 shadow-sm cursor-pointer" style="background-color: #2E6F40 !important;">
                                                <i class="fa-solid fa-lock mr-1 text-[8px]"></i> Log In to Book
                                            </a>
                                        @else
                                            <a href="{{ route('bookings.create', $service) }}" class="px-2.5 py-1.5 text-white font-extrabold text-[9px] rounded-lg tracking-wider uppercase transition-all select-none hover:bg-green-800 flex items-center justify-center shrink-0 shadow-sm cursor-pointer" style="background-color: #2E6F40 !important;">
                                                Book Now
                                            </a>
                                        @endguest
                                    </div>

                                </div>
                            </div>
                        @empty
                            <!-- Beautiful empty card container -->
                            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-[#C1E1C9] select-none space-y-4 shadow-sm">
                                <div class="w-14 h-14 rounded-full bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center mx-auto shadow-sm">
                                    <i class="fa-solid fa-leaf text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-extrabold text-gray-900">No eco-services found</h4>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto leading-relaxed">We couldn't find any composting or waste services matching your current filters. Try resetting search criteria or cities.</p>
                                </div>
                                <a href="{{ route('services.list') }}" class="inline-block px-5 py-2 text-white font-bold text-xs rounded-xl hover:bg-green-900 transition-colors" style="background-color: #2E6F40 !important;">
                                    View All Services
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Redesigned Pagination Panel (to match the mockup exactly) -->
                    <div class="flex items-center justify-between border-t border-gray-100 pt-6 mt-8 select-none">
                        <div class="text-[11px] text-gray-400 font-bold">
                            Showing 1 to {{ min(8, $services->count()) }} of {{ $services->count() }} services
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors cursor-pointer">
                                <i class="fa-solid fa-chevron-left text-[9px]"></i>
                            </button>
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded bg-[#2E6F40] text-white text-[11px] font-bold shadow-sm">
                                1
                            </button>
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-600 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                2
                            </button>
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-600 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                3
                            </button>
                            <span class="text-gray-400 text-xs px-1 font-bold">...</span>
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-600 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                6
                            </button>
                            <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>

<script>
    // Handles sidebar category selection and immediate search form submission
    function selectCategory(cat) {
        document.getElementById('category_input').value = cat;
        document.getElementById('filters_form').submit();
    }
    
    // Handles segmented control tab switching
    function selectTab(tabType) {
        if (tabType === 'all') {
            document.getElementById('verified_input').value = '0';
            document.getElementById('top_rated_input').value = '0';
        } else if (tabType === 'verified') {
            document.getElementById('verified_input').value = '1';
            document.getElementById('top_rated_input').value = '0';
        } else if (tabType === 'top_rated') {
            document.getElementById('verified_input').value = '0';
            document.getElementById('top_rated_input').value = '1';
        }
        document.getElementById('filters_form').submit();
    }
</script>
@endsection