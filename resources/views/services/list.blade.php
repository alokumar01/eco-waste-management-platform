@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('no_container', true)
@section('no_top_nav', Auth::check() && Auth::user()->role === 'admin')

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

    .segment-pill[class*="bg-[#3E8B3A]"] span {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
</style>

<div class="flex {{ Auth::check() && Auth::user()->role === 'admin' ? 'h-screen overflow-hidden' : 'min-h-screen' }} bg-[#FAFCFB] font-sans">
    
    @if(Auth::check() && Auth::user()->role === 'admin')
        @include('admin-dashboard-sidebar')
    @endif

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @if(Auth::check() && Auth::user()->role === 'admin')
            @include('admin-dashboard-header')
        @endif

        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto">
            <div class="greenloop-directory py-6 select-none bg-[#FAFCFB] px-4 sm:px-6 lg:px-8">
                <div class="max-w-[1400px] mx-auto">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Two Column Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        
                        <!-- 1. LEFT SIDEBAR: Filters Panel inside Form -->
                        <form id="filters_form" action="{{ route('services.list') }}" method="GET" class="lg:col-span-3 space-y-6">
                            <!-- Hidden parameters for persistent state -->
                            <input type="hidden" name="category" id="category_input" value="{{ request('category', 'All Categories') }}">
                            <input type="hidden" name="verified" id="verified_input" value="{{ request('verified', '0') }}">
                            <input type="hidden" name="top_rated" id="top_rated_input" value="{{ request('top_rated', '0') }}">

                            <div class="filter-card rounded-2xl p-5 space-y-6 relative overflow-hidden">
                                @guest
                                    <!-- Beautiful glassmorphic lock overlay -->
                                    <div class="absolute inset-0 bg-white/75 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center p-4 text-center select-none animate-in fade-in duration-300">
                                        <div class="w-10 h-10 rounded-full bg-[#E8F5E9] text-[#2E6F40] flex items-center justify-center mb-2 shadow-sm border border-[#C1E1C9]/50">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </div>
                                        <h4 class="text-xs font-bold text-gray-900">Filters Locked</h4>
                                        <p class="text-[9px] text-gray-400 font-semibold mt-1 max-w-[150px] leading-relaxed">Log in as customer to unlock filters & map features.</p>
                                    </div>
                                @endguest

                                <!-- Search filter group -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Search Services</label>
                                    <div class="relative">
                                        <input type="text" name="search" placeholder="e.g. food waste..." value="{{ request('search') }}"
                                            class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#2E6F40] focus:border-[#2E6F40] bg-gray-50/20 text-gray-700 font-medium">
                                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Filter -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Service Location</label>
                                    <div class="relative">
                                        <input type="text" name="city" placeholder="e.g. Bengaluru" value="{{ request('city') }}"
                                            class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#2E6F40] focus:border-[#2E6F40] bg-gray-50/20 text-gray-700 font-medium">
                                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#2E6F40] pointer-events-none">
                                            <i class="fa-solid fa-location-dot text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="h-px bg-gray-100"></div>

                                <!-- Category Navigation -->
                                <div class="space-y-2.5">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Categories</label>
                                    <div class="flex flex-col gap-1">
                                        @foreach($categoriesList as $catName => $count)
                                            <button type="button" onclick="selectCategory('{{ $catName }}')" 
                                                class="category-item flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-650 hover:bg-gray-50 hover:text-gray-900 transition-colors text-left cursor-pointer {{ request('category', 'All Categories') == $catName ? 'active' : '' }}">
                                                <span>{{ $catName }}</span>
                                                <span class="text-[9.5px] bg-gray-100 px-2 py-0.5 rounded-full text-gray-450 font-bold border border-gray-200/50">{{ $count }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="h-px bg-gray-100"></div>

                                <!-- Service Type Filter -->
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Service Mode</label>
                                    <div class="space-y-2">
                                        @foreach($typeCounts as $typeName => $count)
                                            <label class="flex items-center gap-3 cursor-pointer">
                                                <input type="checkbox" name="service_type[]" value="{{ $typeName }}" 
                                                    class="custom-input w-4 h-4 rounded border-gray-300 text-[#2E6F40] focus:ring-[#2E6F40] cursor-pointer"
                                                    {{ is_array(request('service_type')) && in_array($typeName, request('service_type')) ? 'checked' : '' }}
                                                    onchange="document.getElementById('filters_form').submit()">
                                                <span class="text-xs font-semibold text-gray-650 flex-1">{{ $typeName }}</span>
                                                <span class="text-[9px] text-gray-400 font-bold">({{ $count }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="h-px bg-gray-100"></div>

                                <!-- Price Range Filter -->
                                <div class="space-y-2.5">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Budget Limit</label>
                                    <select name="price_range" onchange="document.getElementById('filters_form').submit()"
                                        class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#2E6F40] focus:border-[#2E6F40] bg-gray-50/20 text-gray-755 font-semibold cursor-pointer">
                                        <option value="">Any Budget</option>
                                        <option value="under-200" {{ request('price_range') == 'under-200' ? 'selected' : '' }}>Under ₹200</option>
                                        <option value="200-500" {{ request('price_range') == '200-500' ? 'selected' : '' }}>₹200 - ₹500</option>
                                        <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>₹500 - ₹1000</option>
                                        <option value="above-1000" {{ request('price_range') == 'above-1000' ? 'selected' : '' }}>Above ₹1000</option>
                                    </select>
                                </div>

                                <!-- Reset Filters button -->
                                @if(request()->filled('search') || request()->filled('city') || request('category', 'All Categories') !== 'All Categories' || request()->filled('service_type') || request()->filled('price_range') || request('verified') == '1' || request('top_rated') == '1')
                                    <div class="pt-2">
                                        <a href="{{ route('services.list') }}" class="block text-center w-full py-2 bg-gray-50 hover:bg-gray-100 text-[#2E6F40] border border-dashed border-[#2E6F40]/30 hover:border-[#2E6F40] rounded-xl text-xs font-bold transition-colors">
                                            Reset Filters
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </form>

                        <!-- 2. RIGHT CONTENT AREA: Directory list -->
                        <div class="lg:col-span-9 space-y-6">
                            
                            <!-- Top Bar controls -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-2xl border border-gray-200/80 shadow-sm">
                                
                                <!-- Pills segmented navigation controls -->
                                <div class="flex items-center bg-gray-50 p-1 rounded-xl border border-gray-100 shrink-0 select-none">
                                    <button type="button" onclick="selectTab('all')" 
                                        class="segment-pill px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ request('verified', '0') == '0' && request('top_rated', '0') == '0' ? 'bg-[#3E8B3A] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                                        <span>All Services</span>
                                        <span class="text-[9px] px-1.5 py-0.2 rounded border bg-white/25 border-white/10 text-white font-black">{{ $categoriesList['All Categories'] }}</span>
                                    </button>
                                    
                                    <button type="button" onclick="selectTab('verified')" 
                                        class="segment-pill px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ request('verified', '0') == '1' ? 'bg-[#3E8B3A] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i>
                                        <span>Verified</span>
                                    </button>
                                    
                                    <button type="button" onclick="selectTab('top_rated')" 
                                        class="segment-pill px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ request('top_rated', '0') == '1' ? 'bg-[#3E8B3A] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                                        <i class="fa-solid fa-star text-[10px]"></i>
                                        <span>Top Rated</span>
                                    </button>
                                </div>

                                <!-- Right sorting dropdown (Associated with filters_form) -->
                                <div class="flex items-center gap-2 justify-end">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Sort By</span>
                                    <select name="sort_by" form="filters_form" onchange="document.getElementById('filters_form').submit()"
                                        class="px-3 py-1.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#2E6F40] focus:border-[#2E6F40] bg-gray-50/20 text-gray-700 font-semibold cursor-pointer">
                                        <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Popularity</option>
                                        <option value="price-low" {{ request('sort_by') == 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price-high" {{ request('sort_by') == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest Listed</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dynamic Results Grid -->
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
                                    
                                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden hover:shadow-[0_12px_28px_rgba(45,106,79,0.045)] hover:border-[#C1E1C9] transition-all duration-300 flex flex-col group relative">
                                        
                                        <!-- Cover Image or premium fallbacks -->
                                        <div class="h-40 w-full relative overflow-hidden bg-gray-50 shrink-0 select-none">
                                            <a href="{{ route('services.show', $service) }}" class="block w-full h-full">
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

                                            @auth
                                                @if(Auth::user()->role !== 'admin')
                                                    <button type="button" onclick="toggleSaveProvider({{ $service->user->id }}, this, event)" class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-white/95 backdrop-blur-sm shadow-sm flex items-center justify-center text-gray-500 hover:text-red-500 hover:scale-105 active:scale-95 transition-all z-20 cursor-pointer focus:outline-none" title="Save Provider">
                                                        <i class="{{ Auth::user()->savedProviders->contains($service->user->id) ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart' }} text-xs"></i>
                                                    </button>
                                                @endif
                                            @endauth
                                            
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
                                                <a href="{{ route('services.show', $service) }}" class="hover:text-[#2E6F40] transition-colors">{{ $service->name }}</a>
                                            </h3>
                                            
                                            <p class="text-[10px] text-gray-500 font-medium leading-relaxed mb-3 line-clamp-2">
                                                {{ $service->description }}
                                            </p>
                                            
                                            <!-- Provider details row -->
                                            <div class="flex items-center gap-2 mb-3 select-none">
                                                <!-- Avatar image -->
                                                <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($service->user->name) . '&background=E8F5E9&color=3E8B3A' }}" class="w-8 h-8 rounded-full object-cover border border-gray-100 shrink-0">
                                                
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
                                                    <a href="{{ route('login') }}" class="px-2.5 py-1.5 text-white font-extrabold text-[9px] rounded-lg tracking-wider uppercase transition-all select-none hover:bg-[#2E6F40] flex items-center justify-center shrink-0 shadow-sm cursor-pointer" style="background-color: #3E8B3A !important; color: #ffffff !important;">
                                                        <i class="fa-solid fa-lock mr-1 text-[8px] text-white"></i> <span class="text-white">Log In to Book</span>
                                                    </a>
                                                @else
                                                    @if(Auth::user()->role === 'admin')
                                                        <div class="flex items-center gap-1.5 shrink-0 justify-end">
                                                            <a href="{{ route('services.show', $service) }}" class="px-2.5 py-1.5 bg-[#2E6F40] hover:bg-green-800 text-white text-[9px] font-extrabold rounded-lg tracking-wider uppercase transition-all shadow-sm">
                                                                View
                                                            </a>
                                                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" data-confirm="Are you sure you want to delete this service permanently?" data-confirm-title="Delete Service" data-confirm-text="Delete" class="inline m-0 p-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-[9px] font-extrabold rounded-lg tracking-wider uppercase transition-all shadow-sm cursor-pointer">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('bookings.create', $service) }}" class="px-2.5 py-1.5 text-white font-extrabold text-[9px] rounded-lg tracking-wider uppercase transition-all select-none hover:bg-[#2E6F40] flex items-center justify-center shrink-0 shadow-sm cursor-pointer" style="background-color: #3E8B3A !important; color: #ffffff !important;">
                                                                <span class="text-white">Book Now</span>
                                                        </a>
                                                    @endif
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
                                        <a href="{{ route('services.list') }}" class="inline-block px-5 py-2 text-white font-bold text-xs rounded-xl hover:bg-[#2E6F40] transition-colors" style="background-color: #3E8B3A !important;">
                                            View All Services
                                        </a>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Redesigned Pagination Panel -->
                            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-[0_2px_10px_rgba(0,0,0,0.01)] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="text-[11px] text-gray-400 font-bold select-none text-center sm:text-left">
                                    SHOWING <span class="text-gray-700">1-{{ count($services) }}</span> OF <span class="text-gray-700">{{ count($services) }}</span> ECO-SERVICES
                                </div>
                                
                                <div class="flex items-center justify-center gap-1.5 select-none">
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-gray-250 bg-gray-50 text-gray-400 cursor-not-allowed">
                                        <i class="fa-solid fa-chevron-left text-[9px]"></i>
                                    </button>
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-[#2E6F40] bg-[#E8F5E9] text-[#2E6F40] text-[11px] font-black shadow-sm">
                                        1
                                    </button>
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-650 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                        2
                                    </button>
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-650 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                        3
                                    </button>
                                    <span class="text-gray-450 text-xs px-1 font-bold">...</span>
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-transparent text-gray-650 hover:bg-gray-50 text-[11px] font-bold transition-colors cursor-pointer">
                                        6
                                    </button>
                                    <button type="button" class="w-7 h-7 flex items-center justify-center rounded border border-gray-250 text-gray-650 hover:bg-gray-50 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
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