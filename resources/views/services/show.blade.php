@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('no_container', true)
@section('no_top_nav', Auth::check() && Auth::user()->role === 'admin')

@section('content')
<div class="flex {{ Auth::check() && Auth::user()->role === 'admin' ? 'h-screen overflow-hidden' : 'min-h-screen' }} bg-[#FAFCFB] font-sans">
    
    @if(Auth::check() && Auth::user()->role === 'admin')
        @include('admin-dashboard-sidebar')
    @endif

    <!-- Main View Panel -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @if(Auth::check() && Auth::user()->role === 'admin')
            @include('admin-dashboard-header')
        @endif

        <!-- Scrollable details panel -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 pb-20">
            <div class="max-w-5xl mx-auto space-y-6">
                
                <!-- Back Button -->
                <div>
                    <a href="{{ route('services.list') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-[#2E6F40] transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Back to Available Services
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Core Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Service Details (2/3) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Images Carousel / Cover -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                            @php
                                $imgPaths = [];
                                if ($service->image_path) {
                                    if (str_starts_with($service->image_path, '[')) {
                                        $imgPaths = json_decode($service->image_path, true) ?: [];
                                    } else {
                                        $imgPaths = [$service->image_path];
                                    }
                                }
                            @endphp

                            @if(!empty($imgPaths))
                                <div class="relative h-96 bg-gray-50">
                                    <img id="main-service-img" src="{{ asset('storage/' . $imgPaths[0]) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                    
                                    @if(count($imgPaths) > 1)
                                        <div class="absolute bottom-4 left-4 right-4 flex gap-2 overflow-x-auto py-2">
                                            @foreach($imgPaths as $index => $path)
                                                <button type="button" onclick="document.getElementById('main-service-img').src = '{{ asset('storage/' . $path) }}'" class="w-16 h-12 rounded-lg border-2 border-white hover:border-[#2E6F40] overflow-hidden shrink-0 transition-all shadow-sm">
                                                    <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover">
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="h-64 bg-gradient-to-br from-[#E2E8E4] to-[#B8C8BD] flex flex-col items-center justify-center select-none text-center p-6">
                                    <i class="fa-solid fa-leaf text-[#2E6F40]/30 text-5xl mb-2"></i>
                                    <h4 class="text-xs font-extrabold text-[#2E6F40]/60 tracking-wider uppercase">GreenLoop Waste Service</h4>
                                </div>
                            @endif
                        </div>

                        <!-- Service General Information -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-[#E8F5E9] text-[#2E6F40] text-[9px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $service->category ?? 'Composting' }}
                                </span>
                                <span class="bg-gray-100 text-gray-700 text-[9px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $service->type ?? 'Pickup Service' }}
                                </span>
                            </div>

                            <h1 class="text-xl md:text-2xl font-black text-gray-900 leading-snug">{{ $service->name }}</h1>
                            
                            <p class="text-xs text-gray-600 font-medium leading-relaxed">
                                {{ $service->description }}
                            </p>

                            @if($service->detailed_description)
                                <div class="h-px bg-gray-50 my-4"></div>
                                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Detailed Overview</h3>
                                <div class="text-xs text-gray-500 font-medium leading-relaxed space-y-2">
                                    {!! nl2br(e($service->detailed_description)) !!}
                                </div>
                            @endif
                        </div>

                        <!-- Acceptable & Non-acceptable materials -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- What We Accept -->
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                                <h4 class="text-xs font-bold text-green-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check"></i> What We Accept
                                </h4>
                                <div class="text-xs text-gray-500 font-medium leading-relaxed">
                                    @if($service->what_we_accept)
                                        {!! nl2br(e($service->what_we_accept)) !!}
                                    @else
                                        <p class="italic text-gray-400">No restrictions specified.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- What We Don't Accept -->
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                                <h4 class="text-xs font-bold text-red-700 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-xmark"></i> What We Don't Accept
                                </h4>
                                <div class="text-xs text-gray-500 font-medium leading-relaxed">
                                    @if($service->what_we_dont_accept)
                                        {!! nl2br(e($service->what_we_dont_accept)) !!}
                                    @else
                                        <p class="italic text-gray-400">No restrictions specified.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Booking Card / Moderation (1/3) -->
                    <div class="space-y-6">
                        
                        <!-- Pricing Details Card -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Service Charge</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-black text-gray-900">₹{{ number_format($service->price, 2) }}</span>
                                    <span class="text-xs text-gray-450 font-semibold">/ {{ $service->unit ?? 'kg' }}</span>
                                </div>
                            </div>

                            <div class="h-px bg-gray-50"></div>

                            <div class="space-y-2 text-xs font-semibold text-gray-500">
                                <div class="flex justify-between">
                                    <span>Duration</span>
                                    <span class="text-gray-800">{{ $service->duration ?? '1 hour' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Type</span>
                                    <span class="text-gray-800">{{ $service->type ?? 'Pickup' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>City</span>
                                    <span class="text-gray-800">{{ $service->city ?? 'Bengaluru' }}</span>
                                </div>
                            </div>

                            <div class="h-px bg-gray-50"></div>

                            <!-- Actions block based on roles -->
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <!-- Admin Moderation Actions -->
                                    <div class="space-y-2.5">
                                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" data-confirm="Are you sure you want to delete this service permanently?" data-confirm-title="Delete Service" data-confirm-text="Delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all cursor-pointer shadow-sm text-center">
                                                Delete Service
                                            </button>
                                        </form>
                                        <div class="text-[10px] text-gray-400 font-medium text-center leading-normal">
                                            As administrator, you can moderate this service card if it violates community rules.
                                        </div>
                                    </div>
                                @elseif(Auth::user()->id === $service->user_id)
                                    <!-- Provider Edit Link -->
                                    <a href="{{ route('services.edit', $service) }}" class="block w-full py-2.5 bg-[#2E6F40] hover:bg-green-800 text-white text-xs font-bold rounded-xl text-center transition-all shadow-sm">
                                        Edit Service
                                    </a>
                                @else
                                    <!-- Customer Booking -->
                                    <a href="{{ route('bookings.create', $service) }}" class="block w-full py-2.5 bg-[#2E6F40] hover:bg-green-800 text-white text-xs font-bold rounded-xl text-center transition-all shadow-sm">
                                        Book Service
                                    </a>
                                @endif
                            @else
                                <!-- Guest Login Redirect -->
                                <a href="{{ route('login') }}" class="block w-full py-2.5 bg-[#2E6F40] hover:bg-green-800 text-white text-xs font-bold rounded-xl text-center transition-all shadow-sm">
                                    Login to Book Service
                                </a>
                            @endauth
                        </div>

                        <!-- Service Provider Info Card -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                            <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide border-b border-gray-50 pb-2.5">Service Provider</h3>
                            
                            <div class="flex items-center gap-3">
                                <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($service->user->name) . '&background=E8F5E9&color=3E8B3A' }}" class="w-12 h-12 rounded-full object-cover border border-gray-100 shrink-0">
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-extrabold text-gray-900 truncate">{{ $service->user->business_name ?? $service->user->name }}</h4>
                                    
                                    @if($service->user->is_verified)
                                        <span class="inline-flex items-center gap-0.5 text-[8px] font-bold text-green-700 bg-green-50 px-2 py-0.2 rounded-full mt-0.5">
                                            <i class="fa-solid fa-circle-check"></i> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-0.5 text-[8px] font-bold text-amber-700 bg-amber-50 px-2 py-0.2 rounded-full mt-0.5">
                                            Pending Verification
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="h-px bg-gray-50"></div>

                            <div class="space-y-2 text-[11px] font-bold text-gray-400">
                                <div class="flex justify-between">
                                    <span>RATING</span>
                                    <span class="text-gray-700 flex items-center gap-0.5">
                                        <i class="fa-solid fa-star text-amber-500 text-[10px]"></i>
                                        {{ number_format($service->user->averageRating() ?: 4.8, 1) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>LOCATION</span>
                                    <span class="text-gray-700">{{ $service->user->city ?? 'Bengaluru' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
