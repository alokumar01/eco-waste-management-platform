@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden select-none">
    @include('provider-dashboard-sidebar')

    @php
        $provider = Auth::user();
        $totalServices = $services->count();
        $activeServices = $services->where('status', 'active')->count();
        $totalBookings = $services->sum(function($s) { return $s->bookings->count(); });
        $avgRating = number_format($provider->averageRating(), 1);
        $reviewCount = $provider->reviewCount();
    @endphp

    <!-- Main Content Area Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <!-- Scrollable Content Body -->
        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">
            @if (session('success'))
                <div class="bg-green-50 border border-green-100 text-provider-green py-2.5 px-4 mb-6 rounded-2xl flex items-center gap-2 text-xs font-bold shadow-sm" role="alert">
                    <svg class="w-4 h-4 text-provider-green shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Heading Title block -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-[#0E2415] tracking-tight">My Services</h1>
                    <p class="text-xs text-gray-400 font-medium mt-1">Manage and monitor all the waste & composting services you've added.</p>
                </div>
                <a href="{{ route('services.create') }}" class="bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors inline-flex items-center gap-2 self-start sm:self-center select-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Service</span>
                </a>
            </div>

            <!-- Modern Statistics Dashboard Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Card 1: Total Services -->
                <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                                <rect x="14" y="14" width="7" height="7" rx="1.5" />
                                <rect x="3" y="14" width="7" height="7" rx="1.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Total Services</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $totalServices }}</span>
                            <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">All listings</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Active Services -->
                <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Active Services</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $activeServices }}</span>
                            <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">Live in catalog</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Bookings -->
                <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Total Bookings</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $totalBookings }}</span>
                            <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">Across all services</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Avg Rating -->
                <div class="bg-white p-4.5 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100/70 flex flex-col justify-between min-w-0">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-provider-green-light text-provider-green">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10.5px] text-gray-400 font-bold uppercase tracking-wider mb-1 truncate">Avg. Rating</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-[22px] font-bold text-gray-900 leading-none tracking-tight">{{ $avgRating }}</span>
                            <span class="text-[10px] font-bold text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded truncate">Based on {{ $reviewCount }} reviews</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time Filter toolbar panel -->
            <div class="bg-white border border-[#E3F2E6] rounded-2xl p-4.5 shadow-sm mb-6 flex flex-col md:flex-row gap-3 items-center justify-between">
                <!-- Search bar -->
                <div class="relative w-full md:w-[280px]">
                    <input type="text" id="serviceSearch" placeholder="Search services..." class="w-full pl-9 pr-4 py-2 border border-[#D2E3D6] rounded-xl text-xs bg-[#FCFDFD] focus:bg-white focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green transition-all placeholder-gray-400 font-semibold" style="padding-left: 2.25rem !important;">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Dropdowns -->
                <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
                    <!-- Status Filter -->
                    <select id="statusFilter" class="px-3.5 py-2 border border-[#D2E3D6] bg-white rounded-xl text-xs font-semibold text-gray-600 focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green shadow-sm select-none">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <!-- Category Filter -->
                    <select id="categoryFilter" class="px-3.5 py-2 border border-[#D2E3D6] bg-white rounded-xl text-xs font-semibold text-gray-600 focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green shadow-sm select-none">
                        <option value="all">All Categories</option>
                        @foreach ($services->pluck('category')->unique()->filter() as $cat)
                            <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                        @endforeach
                    </select>

                    <!-- Type Filter -->
                    <select id="typeFilter" class="px-3.5 py-2 border border-[#D2E3D6] bg-white rounded-xl text-xs font-semibold text-gray-600 focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green shadow-sm select-none">
                        <option value="all">All Service Types</option>
                        <option value="pickup">Pickup</option>
                        <option value="onsite">On-site Visit</option>
                    </select>

                    <!-- Sort -->
                    <select id="sortFilter" class="px-3.5 py-2 border border-[#D2E3D6] bg-white rounded-xl text-xs font-semibold text-gray-600 focus:outline-none focus:ring-1 focus:ring-provider-green focus:border-provider-green shadow-sm select-none">
                        <option value="newest">Sort By: Newest</option>
                        <option value="oldest">Sort By: Oldest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Premium Services Table Block -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#E3F2E6] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="servicesTable">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Service</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Category</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Type</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Price</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Bookings</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Rating</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none">Status</th>
                                <th class="px-6 py-4.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider select-none text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="servicesTableBody">
                            @forelse ($services as $service)
                                <tr class="hover:bg-gray-50/30 transition-colors service-row" 
                                    data-name="{{ strtolower($service->name) }}" 
                                    data-desc="{{ strtolower($service->description) }}"
                                    data-status="{{ strtolower($service->status) }}" 
                                    data-category="{{ strtolower($service->category) }}" 
                                    data-type="{{ strtolower($service->type) }}" 
                                    data-price="{{ $service->price }}" 
                                    data-created="{{ strtotime($service->created_at) }}">
                                    <!-- Service Listing with Photo -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-13 h-13 rounded-xl bg-gray-50 border border-gray-100 shrink-0 overflow-hidden flex items-center justify-center relative select-none">
                                                @if ($service->image_path)
                                                    <img src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover" />
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-[#E2E4DE] to-[#C2C9BD] flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-provider-green/60" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3c4 0 7 3 7 7v4c0 3-3 5-7 5s-7-2-7-5v-4c0-4 3-7 7-7z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h4 class="font-bold text-xs text-gray-900 truncate leading-snug">{{ $service->name }}</h4>
                                                <p class="text-[10px] text-gray-400 font-medium mt-1 truncate max-w-[280px] leading-relaxed">{{ $service->description }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category Pill -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $catName = $service->category ?: 'Composting';
                                            $catColor = 'bg-provider-green-light text-provider-green border-provider-green/20';
                                            if (stripos($catName, 'recycl') !== false) {
                                                $catColor = 'bg-purple-50 text-purple-700 border-purple-100/50';
                                            } elseif (stripos($catName, 'waste') !== false) {
                                                $catColor = 'bg-blue-50 text-blue-700 border-blue-100/50';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold border {{ $catColor }}">
                                            {{ $catName }}
                                        </span>
                                    </td>

                                    <!-- Type (Pickup / Onsite) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($service->type == 'pickup')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold border border-provider-green/20 bg-provider-green-light text-provider-green">
                                                Pickup Service
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[9px] font-bold border border-blue-100 bg-blue-50 text-blue-700">
                                                On-site Service
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Pricing detail -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-xs text-gray-900">₹{{ number_format($service->price, 0) }}</span>
                                        <span class="text-[9.5px] text-gray-400 font-bold">/{{ $service->unit ?: 'kg' }}</span>
                                    </td>

                                    <!-- Bookings count -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-xs text-gray-500">{{ $service->bookings->count() }}</span>
                                    </td>

                                    <!-- Rating details -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $sRating = number_format($service->user->averageRating(), 1);
                                            $sReviews = $service->user->reviewCount();
                                        @endphp
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-900 mt-0.5">{{ $sRating }}</span>
                                            <span class="text-[9.5px] text-gray-400 font-bold mt-0.5">({{ $sReviews }})</span>
                                        </div>
                                    </td>

                                    <!-- Listing Status capsule tags -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($service->status == 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-provider-green-light text-provider-green border border-provider-green/20">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-red-50 text-red-600 border border-red-100">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Table actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                        <div class="flex items-center justify-end gap-2.5 select-none">
                                            <!-- Edit button -->
                                            <a href="{{ route('services.edit', $service->id) }}" class="p-1.5 border border-gray-100 hover:border-provider-green bg-white text-gray-500 hover:text-provider-green rounded-lg transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <!-- Delete Form trigger -->
                                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service listing?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 border border-gray-100 hover:border-red-200 bg-white text-gray-500 hover:text-red-600 rounded-lg transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRow">
                                    <td colspan="8" class="px-6 py-16 text-center select-none">
                                        <div class="max-w-[340px] mx-auto flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-2xl bg-provider-green-light flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-provider-green" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                            <h3 class="font-extrabold text-sm text-gray-900 leading-snug">No Services Found</h3>
                                            <p class="text-[10px] text-gray-400 font-semibold mt-1 leading-relaxed">Add your very first eco-composting service listing to begin accepting bookings!</p>
                                            <a href="{{ route('services.create') }}" class="mt-4 bg-provider-green hover:bg-provider-green-dark text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors inline-flex items-center gap-2 select-none">Add First Service</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="noResultsRow" class="hidden">
                                <td colspan="8" class="px-6 py-16 text-center select-none">
                                    <div class="max-w-[340px] mx-auto flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <h3 class="font-extrabold text-sm text-gray-900 leading-snug">No match found</h3>
                                        <p class="text-[10px] text-gray-400 font-semibold mt-1 leading-relaxed">No services match your active search or dropdown filters.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Information -->
                <div class="bg-gray-50/50 border-t border-gray-100 px-6 py-4 flex items-center justify-between select-none">
                    <p class="text-[11px] text-gray-400 font-semibold" id="tablePaginationInfo">
                        Showing 1 to {{ $services->count() }} of {{ $services->count() }} services
                    </p>
                    <div class="flex items-center gap-1.5">
                        <button class="px-3 py-1.5 border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-bold text-gray-500 disabled:opacity-50" disabled>&lt;</button>
                        <button class="px-3.5 py-1.5 bg-provider-green text-white rounded-lg text-xs font-bold shadow-sm">1</button>
                        <button class="px-3 py-1.5 border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-bold text-gray-500 disabled:opacity-50" disabled>&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Real-time Filter & Sort script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('serviceSearch');
    const statusSelect = document.getElementById('statusFilter');
    const categorySelect = document.getElementById('categoryFilter');
    const typeSelect = document.getElementById('typeFilter');
    const sortSelect = document.getElementById('sortFilter');
    const tableBody = document.getElementById('servicesTableBody');
    const rows = Array.from(tableBody.querySelectorAll('.service-row'));
    const noResultsRow = document.getElementById('noResultsRow');
    const pagInfo = document.getElementById('tablePaginationInfo');

    function filterRows() {
        const query = searchInput.value.toLowerCase().trim();
        const status = statusSelect.value;
        const category = categorySelect.value;
        const type = typeSelect.value;

        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const desc = row.getAttribute('data-desc');
            const rowStatus = row.getAttribute('data-status');
            const rowCat = row.getAttribute('data-category');
            const rowType = row.getAttribute('data-type');

            const matchesSearch = !query || name.includes(query) || desc.includes(query);
            const matchesStatus = status === 'all' || rowStatus === status;
            const matchesCat = category === 'all' || rowCat === category;
            const matchesType = type === 'all' || rowType === type;

            if (matchesSearch && matchesStatus && matchesCat && matchesType) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Show/Hide no result row
        if (visibleCount === 0 && rows.length > 0) {
            noResultsRow.classList.remove('hidden');
        } else {
            noResultsRow.classList.add('hidden');
        }

        pagInfo.textContent = `Showing 1 to ${visibleCount} of ${visibleCount} services`;
    }

    function sortRows() {
        const sortBy = sortSelect.value;

        let sorted = [...rows];

        if (sortBy === 'newest') {
            sorted.sort((a, b) => b.getAttribute('data-created') - a.getAttribute('data-created'));
        } else if (sortBy === 'oldest') {
            sorted.sort((a, b) => a.getAttribute('data-created') - b.getAttribute('data-created'));
        } else if (sortBy === 'price-low') {
            sorted.sort((a, b) => parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price')));
        } else if (sortBy === 'price-high') {
            sorted.sort((a, b) => parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price')));
        }

        // Re-append sorted rows to table body
        sorted.forEach(row => tableBody.appendChild(row));
    }

    searchInput.addEventListener('input', filterRows);
    statusSelect.addEventListener('change', filterRows);
    categorySelect.addEventListener('change', filterRows);
    typeSelect.addEventListener('change', filterRows);
    sortSelect.addEventListener('change', () => {
        sortRows();
        filterRows();
    });
});
</script>
@endsection
