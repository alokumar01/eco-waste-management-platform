@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('content')
<!-- Import premium Google Font for unmatched visual aesthetics -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    
    .greenloop-directory {
        font-family: 'Inter', sans-serif !important;
    }
    
    /* Elegant glassmorphic filter styling */
    .filter-card {
        background: #ffffff;
        border: 1px solid #E8F2EC;
        box-shadow: 0 4px 20px rgba(26, 77, 46, 0.02);
    }
    
    /* Styled custom radio/checkbox colors */
    .custom-input:checked {
        background-color: #1A4D2E !important;
        border-color: #1A4D2E !important;
    }
    
    /* Category item active state */
    .category-item.active {
        background-color: #E8F5E9 !important;
        color: #1A4D2E !important;
        font-weight: 700 !important;
    }
    
    /* Segmented pill active state */
    .segment-pill.active {
        background-color: #1A4D2E !important;
        color: #ffffff !important;
        border-color: #1A4D2E !important;
    }
</style>

<div class="greenloop-directory py-6 select-none bg-[#F7F9F8] min-h-screen px-4 sm:px-6 lg:px-8">
    <div class="max-w-[1400px] mx-auto">
        
        <!-- Redesigned Search & City Header Panel -->
        <form id="filters_form" action="{{ route('services.list') }}" method="GET" class="space-y-6">
            <!-- Hidden parameters for persistent state -->
            <input type="hidden" name="category" id="category_input" value="{{ request('category', 'All Categories') }}">
            <input type="hidden" name="verified" id="verified_input" value="{{ request('verified', '0') }}">
            <input type="hidden" name="top_rated" id="top_rated_input" value="{{ request('top_rated', '0') }}">
            
            <div class="bg-white border border-[#E3F2E6] p-4 rounded-2xl shadow-[0_4px_30px_rgba(45,106,79,0.015)] flex flex-col md:flex-row gap-3">
                <!-- Search services input -->
                <div class="relative flex-1 group">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#1A4D2E] transition-colors z-10">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services (e.g. food waste, composting, e-waste)..." class="block w-full h-11 pl-10 pr-4 border border-[#D2E3D6] rounded-xl text-xs bg-[#FCFDFD] focus:bg-white placeholder-gray-400 font-medium focus:border-[#1A4D2E] focus:ring-1 focus:ring-[#1A4D2E] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                </div>

                <!-- Filter by City input -->
                <div class="relative w-full md:w-[260px] group">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400 group-focus-within:text-[#1A4D2E] transition-colors z-10">
                        <i class="fa-solid fa-location-dot text-sm"></i>
                    </span>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by City..." class="block w-full h-11 pl-10 pr-4 border border-[#D2E3D6] rounded-xl text-xs bg-[#FCFDFD] focus:bg-white placeholder-gray-400 font-medium focus:border-[#1A4D2E] focus:ring-1 focus:ring-[#1A4D2E] transition-all shadow-sm" style="padding-left: 2.6rem !important;">
                </div>

                <!-- Search Button -->
                <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto h-11 px-6 bg-[#1A4D2E] hover:bg-green-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm hover:shadow active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        Search
                    </button>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="lg:grid lg:grid-cols-4 gap-8 items-start">
                
                <!-- 1. LEFT SIDEBAR: Filters Panel -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="filter-card rounded-2xl p-5 space-y-6">
                        
                        <!-- Header row -->
                        <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                            <span class="text-xs font-extrabold text-gray-900 tracking-wider uppercase">Filters</span>
                            <a href="{{ route('services.list') }}" class="text-[11px] font-bold text-[#1A4D2E] hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-rotate-left text-[9px]"></i> Reset
                            </a>
                        </div>
                        
                        <!-- Service Category Accordion -->
                        <div class="space-y-3">
                            <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Service Category</span>
                            <div class="space-y-1.5">
                                @foreach($categoriesList as $name => $count)
                                    @php
                                        $isActive = request('category', 'All Categories') === $name;
                                    @endphp
                                    <button type="button" onclick="selectCategory('{{ $name }}')" class="category-item w-full flex items-center justify-between px-3 py-2 rounded-xl text-left text-xs font-medium text-gray-600 hover:bg-gray-50 transition-all cursor-pointer {{ $isActive ? 'active' : '' }}">
                                        <div class="flex items-center gap-2">
                                            @if($name == 'All Categories')
                                                <i class="fa-solid fa-grip text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Composting')
                                                <i class="fa-solid fa-leaf text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Recycling')
                                                <i class="fa-solid fa-recycle text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'E-Waste')
                                                <i class="fa-solid fa-laptop text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Organic Waste')
                                                <i class="fa-solid fa-apple-whole text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @elseif($name == 'Garden Waste')
                                                <i class="fa-solid fa-seedling text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @else
                                                <i class="fa-solid fa-industry text-[11px] {{ $isActive ? 'text-[#1A4D2E]' : 'text-gray-400' }}"></i>
                                            @endif
                                            <span>{{ $name }}</span>
                                        </div>
                                        <span class="text-[9.5px] font-bold {{ $isActive ? 'bg-[#1A4D2E] text-white' : 'bg-gray-100 text-gray-400' }} px-1.5 py-0.5 rounded-full">{{ $count }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Service Type Accordion -->
                        <div class="space-y-3 pt-2 border-t border-gray-50">
                            <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Service Type</span>
                            <div class="space-y-2.5">
                                @foreach($typeCounts as $type => $count)
                                    @php
                                        $checked = is_array(request('service_type')) ? in_array($type, request('service_type')) : request('service_type') === $type;
                                    @endphp
                                    <label class="flex items-center justify-between text-xs font-semibold text-gray-600 cursor-pointer group">
                                        <div class="flex items-center gap-2.5">
                                            <input type="checkbox" name="service_type[]" value="{{ $type }}" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 rounded text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $checked ? 'checked' : '' }}>
                                            <span>{{ $type }}</span>
                                        </div>
                                        <span class="text-[9.5px] font-bold text-gray-400">{{ $count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Price Range Accordion -->
                        <div class="space-y-3 pt-2 border-t border-gray-50">
                            <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Price Range</span>
                            <div class="space-y-2.5">
                                @php
                                    $priceRange = request('price_range');
                                @endphp
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ !$priceRange ? 'checked' : '' }}>
                                    <span>All Prices</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="under-200" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $priceRange === 'under-200' ? 'checked' : '' }}>
                                    <span>Under ₹200</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="200-500" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $priceRange === '200-500' ? 'checked' : '' }}>
                                    <span>₹200 - ₹500</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="500-1000" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $priceRange === '500-1000' ? 'checked' : '' }}>
                                    <span>₹500 - ₹1000</span>
                                </label>
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="price_range" value="above-1000" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $priceRange === 'above-1000' ? 'checked' : '' }}>
                                    <span>Above ₹1000</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Rating Accordion -->
                        <div class="space-y-3 pt-2 border-t border-gray-50">
                            <span class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Rating</span>
                            <div class="space-y-2.5">
                                @php
                                    $ratingVal = request('rating');
                                @endphp
                                <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                    <input type="radio" name="rating" value="" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ !$ratingVal ? 'checked' : '' }}>
                                    <span>All Ratings</span>
                                </label>
                                @foreach([4, 3, 2, 1] as $stars)
                                    <label class="flex items-center gap-2.5 text-xs font-semibold text-gray-600 cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $stars }}" onchange="document.getElementById('filters_form').submit()" class="custom-input w-4 h-4 text-[#1A4D2E] border-gray-300 focus:ring-0 cursor-pointer" {{ $ratingVal == $stars ? 'checked' : '' }}>
                                        <div class="flex items-center gap-1">
                                            <div class="flex text-yellow-400 gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star text-[9.5px] {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-200' }}"></i>
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

                <!-- 2. RIGHT CONTENT: Services Catalog display -->
                <div class="lg:col-span-3 space-y-6 mt-6 lg:mt-0">
                    
                    <!-- Section Title & Description -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 select-none">
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-950 tracking-tight">All Services</h2>
                            <p class="text-xs text-gray-500 font-semibold mt-1">Find the best waste management and composting services near you.</p>
                        </div>
                    </div>
                    
                    <!-- Segmented Pills Controls Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-[#E3F2E6] px-4 py-3 rounded-2xl shadow-[0_2px_15px_rgba(45,106,79,0.01)]">
                        <!-- Pills -->
                        <div class="flex flex-wrap items-center gap-2">
                            @php
                                $isVerifiedTab = request('verified') == '1';
                                $isTopRatedTab = request('top_rated') == '1';
                                $isAllTab = !$isVerifiedTab && !$isTopRatedTab;
                            @endphp
                            <button type="button" onclick="selectTab('all')" class="segment-pill text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-gray-100 cursor-pointer transition-all select-none {{ $isAllTab ? 'segment-pill active' : 'bg-gray-50/50 hover:bg-gray-100/60 text-gray-600 border-gray-200/50' }}">
                                All Services <span class="ml-1 text-[9.5px] px-1.5 py-0.2 rounded-full {{ $isAllTab ? 'bg-[#F4FCF4] text-[#1A4D2E]' : 'bg-gray-100 text-gray-400' }}">{{ $services->count() }}</span>
                            </button>
                            <button type="button" onclick="selectTab('verified')" class="segment-pill text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-gray-100 cursor-pointer transition-all select-none {{ $isVerifiedTab ? 'segment-pill active' : 'bg-gray-50/50 hover:bg-gray-100/60 text-gray-600 border-gray-200/50' }}">
                                <i class="fa-solid fa-circle-check mr-1"></i> Verified Providers
                            </button>
                            <button type="button" onclick="selectTab('top_rated')" class="segment-pill text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-gray-100 cursor-pointer transition-all select-none {{ $isTopRatedTab ? 'segment-pill active' : 'bg-gray-50/50 hover:bg-gray-100/60 text-gray-600 border-gray-200/50' }}">
                                <i class="fa-solid fa-star mr-1"></i> Top Rated
                            </button>
                        </div>
                        
                        <!-- Sort by selector -->
                        <div class="flex items-center gap-2 select-none">
                            <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider shrink-0">Sort by:</span>
                            <select name="sort_by" onchange="document.getElementById('filters_form').submit()" class="text-xs font-bold text-gray-700 bg-[#FCFDFD] border border-[#D2E3D6] rounded-xl px-3 py-1.5 focus:ring-0 focus:border-[#1A4D2E] cursor-pointer">
                                <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="price-low" {{ request('sort_by') == 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price-high" {{ request('sort_by') == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                            </select>
                        </div>
                    </div>

                    <!-- Services Dynamic Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
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
                            
                            <div class="bg-white rounded-2xl shadow-[0_2px_12px_rgba(45,106,79,0.015)] border border-[#E8F2EC] overflow-hidden hover:shadow-[0_12px_28px_rgba(45,106,79,0.055)] hover:border-[#C1E1C9] transition-all duration-300 flex flex-col group relative">
                                
                                <!-- Cover Image or premium fallbacks -->
                                <div class="h-40 w-full relative overflow-hidden bg-gray-50 shrink-0 select-none">
                                    <a href="{{ route('bookings.create', $service) }}" class="block w-full h-full">
                                        @if ($imgPath)
                                            <img src="{{ asset('storage/' . $imgPath) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $service->name }}">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-[#E2E8E4] to-[#B8C8BD] flex flex-col items-center justify-center relative select-none">
                                                <i class="fa-solid fa-leaf text-[#1A4D2E]/40 text-3xl mb-1"></i>
                                                <span class="text-[8px] font-extrabold text-[#1A4D2E]/60 tracking-widest uppercase">GreenLoop</span>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Category Tag Overlay -->
                                    <span class="absolute top-3 left-3 bg-[#1A4D2E]/90 backdrop-blur-md text-white text-[8px] font-bold px-2 py-0.5 rounded uppercase tracking-wider shadow-sm z-10">
                                        {{ strtoupper($service->category ?? 'Composting') }}
                                    </span>

                                    <!-- Price Pill Overlay -->
                                    <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-md text-gray-950 text-[10.5px] font-bold px-2.5 py-0.5 rounded-lg shadow-sm z-10 border border-[#E3F2E6]">
                                        ₹{{ number_format($service->price, 0) }}<span class="text-[8.5px] text-gray-400 font-semibold">/{{ $service->unit ?? 'kg' }}</span>
                                    </span>
                                    
                                    <!-- Visual Favorite heart overlay -->
                                    <button type="button" class="absolute right-3 top-10 w-7 h-7 rounded-full bg-white/95 border border-gray-100 flex items-center justify-center text-gray-400 hover:text-red-500 active:scale-95 transition-all shadow-sm z-10 cursor-pointer">
                                        <i class="fa-regular fa-heart text-[10px]"></i>
                                    </button>
                                </div>

                                <!-- Card details body -->
                                <div class="p-4 flex flex-col flex-1">
                                    <h3 class="text-[14px] font-extrabold text-gray-950 group-hover:text-[#1A4D2E] transition-colors leading-tight line-clamp-1 mb-1">
                                        <a href="{{ route('bookings.create', $service) }}">{{ $service->name }}</a>
                                    </h3>
                                    
                                    <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 line-clamp-2">
                                        {{ $service->description }}
                                    </p>
                                    
                                    <!-- Provider details row -->
                                    <div class="flex items-center gap-2.5 min-w-0 mb-4 select-none">
                                        <!-- Avatar image -->
                                        <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($service->user->name) . '&background=E8F5E9&color=1B7339' }}" class="w-8 h-8 rounded-full object-cover border border-gray-100/60 shrink-0">
                                        
                                        <div class="min-w-0 flex-1">
                                            <!-- Provider business name with Verified badges -->
                                            <div class="flex items-center gap-1 min-w-0">
                                                <span class="text-[11px] font-bold text-gray-950 truncate">{{ $service->user->business_name ?? $service->user->name }}</span>
                                                @if($service->user->verification_document)
                                                    <i class="fa-solid fa-circle-check text-emerald-600 text-[10px] shrink-0" title="Verified Provider"></i>
                                                @endif
                                            </div>
                                            
                                            <!-- Stars / Rating / Location row -->
                                            <div class="flex items-center gap-1.5 select-none leading-none mt-0.5">
                                                <div class="flex text-yellow-400 gap-0.5 shrink-0">
                                                    @php $rating = round($service->user->averageRating() ?: 4); @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa-solid fa-star text-[8px] {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-[8px] text-gray-400 font-bold">({{ $service->user->reviewCount() }})</span>
                                                <span class="text-gray-300 text-[8px]">•</span>
                                                <span class="text-[8.5px] text-gray-400 font-bold flex items-center gap-0.5 truncate">
                                                    <i class="fa-solid fa-location-dot text-[#1A4D2E]/60 text-[8px] shrink-0"></i>
                                                    {{ $service->user->city ?? 'Bengaluru' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bottom meta tags & Book Now row -->
                                    <div class="border-t border-gray-100 pt-3 flex items-center justify-between gap-3 mt-auto">
                                        <div>
                                            <span class="bg-[#F4FCF4] border border-[#D9ECD8]/40 text-[#1A4D2E] text-[8.5px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider select-none">
                                                {{ strtoupper($service->type ?? 'Pickup Service') }}
                                            </span>
                                        </div>
                                        
                                        <a href="{{ route('bookings.create', $service) }}" class="px-3.5 py-1.5 text-white font-bold text-[10.5px] rounded-lg tracking-wider uppercase transition-all select-none hover:bg-green-900 flex items-center justify-center shrink-0 shadow-sm cursor-pointer" style="background-color: #1A4D2E !important;">
                                            Book Now
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <!-- Beautiful empty card container -->
                            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-[#C1E1C9] select-none space-y-4 shadow-sm">
                                <div class="w-14 h-14 rounded-full bg-[#E8F5E9] text-[#1A4D2E] flex items-center justify-center mx-auto shadow-sm">
                                    <i class="fa-solid fa-leaf text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-extrabold text-gray-900">No eco-services found</h4>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto leading-relaxed">We couldn't find any composting or waste services matching your current filters. Try resetting search criteria or cities.</p>
                                </div>
                                <a href="{{ route('services.list') }}" class="inline-block px-5 py-2 text-white font-bold text-xs rounded-xl hover:bg-green-900 transition-colors" style="background-color: #1A4D2E !important;">
                                    View All Services
                                </a>
                            </div>
                        @endforelse
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