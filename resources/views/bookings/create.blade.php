@extends('layouts.app')
@section('no_container', true)

@section('content')
<!-- Warm Background Wrapper -->
<div class="min-h-screen bg-[#F8F9FA] font-sans pb-16 select-none">
    
    <!-- Top Padding for spacing under header -->
    <div class="max-w-[1250px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        
        <!-- Back link -->
        <a href="{{ route('services.list') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1B7339] hover:underline mb-6 transition-all group select-none">
            <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Services</span>
        </a>

        <!-- Main Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Column: Service Details (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main details & gallery -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.015)] space-y-6">
                    
                    <!-- Cover image & mini gallery -->
                    <div class="space-y-3">
                        <div class="h-80 w-full rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 select-none">
                            @if ($service->image_path)
                                <img id="service_cover_image" src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover" alt="{{ $service->name }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#E2E4DE] to-[#C2C9BD] flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-[#609953]/60 mb-2" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3c4 0 7 3 7 7v4c0 3-3 5-7 5s-7-2-7-5v-4c0-4 3-7 7-7z" />
                                    </svg>
                                    <span class="text-xs font-bold text-gray-500 tracking-wider uppercase">GreenLoop Platform</span>
                                </div>
                            @endif
                        </div>

                        <!-- Mini Gallery Grid -->
                        @if (count($service->images) > 1)
                            <div class="flex flex-wrap gap-3 select-none">
                                @foreach ($service->images as $index => $imgPath)
                                    <div onclick="changeCoverImage('{{ asset('storage/' . $imgPath) }}', this)" 
                                         class="w-20 h-16 rounded-xl overflow-hidden border-2 {{ $index === 0 ? 'border-[#1B7339]' : 'border-gray-100' }} bg-gray-50 cursor-pointer select-none transition-all hover:scale-105 active:scale-95 duration-200 gallery-thumb">
                                        <img src="{{ asset('storage/' . $imgPath) }}" class="w-full h-full object-cover" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Meta info title card -->
                    <div class="space-y-3 pt-2">
                        <span class="inline-block bg-[#EAF5EE] text-[#1B7339] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider select-none">
                            {{ $service->category ?? 'Composting' }}
                        </span>
                        
                        <h1 class="text-3xl font-extrabold text-gray-950 tracking-tight leading-tight">
                            {{ $service->name }}
                        </h1>
                        
                        <p class="text-sm text-gray-500 font-medium leading-relaxed">
                            {{ $service->description }}
                        </p>

                        <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-gray-500 pt-2 select-none">
                            <span class="flex items-center gap-1 text-[#1B7339]">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ number_format($service->user->averageRating(), 1) }} ({{ $service->user->reviewCount() }} reviews)
                            </span>
                            <span class="text-gray-300">•</span>
                            <span class="flex items-center gap-1.5 text-[#1B7339]">
                                <svg class="w-4.5 h-4.5 text-[#1B7339]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Verified Provider
                            </span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-px bg-gray-100 my-2"></div>

                    <!-- Provider Block Details -->
                    <div class="flex items-center justify-between bg-[#F8F9FA]/50 border border-gray-100/70 p-4 rounded-2xl select-none">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-full bg-[#E8F5E9] overflow-hidden flex items-center justify-center text-[#1B7339] font-bold text-sm border border-[#C1DDC6]/30">
                                @if ($service->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $service->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($service->user->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="font-extrabold text-sm text-gray-900 leading-tight">{{ $service->user->business_name ?? $service->user->name }}</p>
                                    <span class="bg-green-100 text-green-700 text-[8.5px] font-bold px-1.5 py-0.5 rounded-md uppercase">Verified</span>
                                </div>
                                <p class="text-[11px] text-gray-400 font-bold uppercase mt-0.5 tracking-wider">Service Provider</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-xs font-bold text-gray-500">
                            <svg class="w-4 h-4 text-[#1B7339]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $service->user->city }}, {{ $service->user->state }}</span>
                        </div>
                    </div>
                </div>

                <!-- About this Service -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.015)] space-y-5">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">About this Service</h3>
                    
                    <div class="text-xs text-gray-500 font-medium leading-relaxed prose prose-sm max-w-none">
                        @if (strip_tags($service->detailed_description) === $service->detailed_description)
                            {!! nl2br(e($service->detailed_description)) !!}
                        @else
                            {!! $service->detailed_description !!}
                        @endif
                    </div>

                    <!-- Feature details card -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 select-none">
                        <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 flex flex-col justify-between">
                            <span class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Service Type</span>
                            <span class="text-xs font-extrabold text-[#1B7339] mt-2 block">{{ ucfirst($service->type) }} Service</span>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 flex flex-col justify-between">
                            <span class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Duration</span>
                            <span class="text-xs font-extrabold text-[#1B7339] mt-2 block">{{ $service->duration ?? 'Ongoing subscription' }}</span>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 flex flex-col justify-between">
                            <span class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">Best For</span>
                            <span class="text-xs font-extrabold text-[#1B7339] mt-2 block">Homes & Offices in {{ $service->city }}</span>
                        </div>
                    </div>
                </div>

                <!-- Reviews layout -->
                @php
                    $reviews = $service->user->reviews()->with('user')->latest()->get();
                    $totalReviews = $reviews->count();
                    $avgRating = number_format($service->user->averageRating(), 1);
                    
                    $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                    foreach ($reviews as $rev) {
                        $starCounts[$rev->rating] = ($starCounts[$rev->rating] ?? 0) + 1;
                    }
                    
                    $starPercentages = [];
                    foreach ($starCounts as $stars => $count) {
                        $starPercentages[$stars] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                    }
                @endphp
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.015)] space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-3 select-none">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Customer Reviews</h3>
                        <div class="text-xs font-bold text-gray-400">Total Reviews: {{ $totalReviews }}</div>
                    </div>

                    <div class="flex flex-col md:flex-row items-center gap-8 py-2 border-b border-gray-50 pb-6">
                        <!-- Rating card left -->
                        <div class="text-center md:border-r border-gray-100 pr-0 md:pr-10 shrink-0 select-none">
                            <p class="text-5xl font-extrabold text-gray-950 leading-none">
                                {{ $avgRating }}
                            </p>
                            <div class="flex text-yellow-400 mt-2.5 justify-center">
                                @php $fullStars = round($avgRating); @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $fullStars ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-[10px] text-gray-400 font-extrabold tracking-widest uppercase mt-2">
                                {{ $totalReviews }} reviews
                            </p>
                        </div>

                        <!-- Rating bars right -->
                        <div class="flex-1 w-full space-y-2.5 select-none">
                            @for ($stars = 5; $stars >= 1; $stars--)
                                <div class="flex items-center gap-3.5 text-xs font-semibold text-gray-500">
                                    <span class="w-10 select-none text-gray-400 font-bold text-[11px]">{{ $stars }} Star</span>
                                    <div class="flex-1 h-2 bg-gray-50 rounded-full overflow-hidden select-none border border-gray-100/30">
                                        <div class="bg-[#1B7339] h-full rounded-full transition-all duration-500" style="width: {{ $starPercentages[$stars] }}%"></div>
                                    </div>
                                    <span class="w-8 text-right select-none text-gray-400 font-bold text-[11px]">{{ $starPercentages[$stars] }}%</span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Reviews List Feed -->
                    <div class="space-y-5 pt-2">
                        @forelse ($reviews as $review)
                            <div class="bg-[#FCFDFD]/60 border border-gray-100/50 p-4.5 rounded-xl space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8.5 h-8.5 rounded-full bg-[#E2E4DE] overflow-hidden flex items-center justify-center text-gray-600 font-bold text-xs">
                                            @if ($review->user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($review->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-xs text-gray-900 leading-none">{{ $review->user->name }}</p>
                                            <p class="text-[9.5px] text-gray-400 font-bold mt-1 uppercase tracking-wider">Customer</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Stars -->
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-bold">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed italic pl-1">
                                    "{{ $review->comment }}"
                                </p>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl select-none">
                                <span class="text-2xl">✨</span>
                                <h4 class="text-xs font-bold text-gray-900 mt-2">No reviews yet</h4>
                                <p class="text-[10px] text-gray-400 mt-0.5">Be the first to complete a booking and leave a rating for this service!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Booking Box Card (1/3 width) -->
            <div class="lg:col-span-1 lg:sticky lg:top-24">
                
                <!-- Main Form Block -->
                <form action="{{ route('bookings.store') }}" method="POST" id="booking_form" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.02)] space-y-6">
                    @csrf
                    
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="scheduled_at" id="final_scheduled_at">

                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 tracking-tight">Book This Service</h2>
                        <p class="text-[11px] text-gray-400 font-semibold mt-0.5">Fill in the details to schedule your service</p>
                    </div>

                    <!-- Price Tag badge block -->
                    <div class="bg-[#F8F9FA] border border-gray-100 px-4 py-3 rounded-xl flex items-center justify-between select-none">
                        <span class="text-xs font-bold text-gray-600">Service Price</span>
                        <span class="text-sm font-extrabold text-[#1B7339]">₹{{ number_format($service->price, 0) }}<span class="text-[10px] text-gray-400 font-bold"> / {{ $service->unit ?? 'kg' }}</span></span>
                    </div>

                    <!-- Date picker field -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider">Select Date <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="date" id="booking_date" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+30 days')) }}" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-bold focus:outline-none focus:ring-1 focus:ring-[#1B7339] focus:border-[#1B7339] text-gray-700 bg-gray-50/20" required>
                        </div>
                        <p class="text-[9px] text-gray-400 font-semibold leading-tight">You can schedule a service any day between today and 30 days from now.</p>
                    </div>

                    <!-- Preferred Time Slot chips grid -->
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider">Preferred Time Slot <span class="text-red-500">*</span></label>
                        
                        <input type="hidden" id="selected_time_slot" value="9:00 AM - 11:00 AM">

                        <div class="grid grid-cols-2 gap-2.5 select-none">
                            <button type="button" onclick="selectTimeSlot('9:00 AM - 11:00 AM', this)" class="time-slot-btn border-2 border-[#1B7339] text-[#1B7339] bg-green-50/30 rounded-xl py-2.5 px-3 text-[11px] font-bold transition-all text-center focus:outline-none select-none">
                                9:00 AM - 11:00 AM
                            </button>
                            <button type="button" onclick="selectTimeSlot('11:00 AM - 1:00 PM', this)" class="time-slot-btn border border-gray-200 text-gray-600 bg-white rounded-xl py-2.5 px-3 text-[11px] font-bold hover:border-gray-300 transition-all text-center focus:outline-none select-none">
                                11:00 AM - 1:00 PM
                            </button>
                            <button type="button" onclick="selectTimeSlot('2:00 PM - 4:00 PM', this)" class="time-slot-btn border border-gray-200 text-gray-600 bg-white rounded-xl py-2.5 px-3 text-[11px] font-bold hover:border-gray-300 transition-all text-center focus:outline-none select-none">
                                2:00 PM - 4:00 PM
                            </button>
                            <button type="button" onclick="selectTimeSlot('4:00 PM - 6:00 PM', this)" class="time-slot-btn border border-gray-200 text-gray-600 bg-white rounded-xl py-2.5 px-3 text-[11px] font-bold hover:border-gray-300 transition-all text-center focus:outline-none select-none">
                                4:00 PM - 6:00 PM
                            </button>
                        </div>
                    </div>

                    <!-- Frequency select block -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider">Frequency <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="frequency" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-gray-50/20 focus:outline-none focus:ring-1 focus:ring-[#1B7339] focus:border-[#1B7339] appearance-none cursor-pointer">
                                <option value="One-time Collection" selected>One-time Collection</option>
                                <option value="Weekly Collection">Weekly Collection</option>
                                <option value="Bi-weekly Collection">Bi-weekly Collection</option>
                                <option value="Monthly Subscription">Monthly Subscription</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Special Instructions textarea -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider">Special Instructions (Optional)</label>
                        <div class="relative">
                            <textarea id="instructions" maxlength="200" rows="3" placeholder="Any specific instructions for the provider..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs text-gray-700 bg-white focus:outline-none focus:ring-1 focus:ring-[#1B7339] focus:border-[#1B7339] resize-none" oninput="updateCharCount(this)"></textarea>
                            <span id="char_counter" class="absolute right-4 bottom-2.5 text-[9px] font-bold text-gray-400">0/200</span>
                        </div>
                    </div>

                    <!-- Total block divider line -->
                    <div class="h-px bg-gray-100"></div>

                    <!-- Total amount display card -->
                    <div class="flex items-center justify-between select-none">
                        <div>
                            <p class="text-xs font-bold text-gray-900 leading-none">Total Amount</p>
                            <p class="text-[9.5px] text-gray-400 font-semibold mt-1">You can cancel or reschedule before the service starts.</p>
                        </div>
                        <p class="text-3xl font-extrabold text-[#1B7339] leading-none">
                            ₹{{ number_format($service->price, 0) }}
                        </p>
                    </div>

                    <!-- Confirm Booking button -->
                    <button type="submit" class="w-full bg-[#1A4D2E] hover:bg-green-900 text-white font-bold text-sm px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors active:scale-[0.99] transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Confirm Booking</span>
                    </button>

                    <!-- Trust secure text -->
                    <div class="flex items-center justify-center gap-1.5 text-[10.5px] font-bold text-gray-400 select-none">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        <span>Your booking is secure and safe</span>
                    </div>
                </form>

                <!-- Help Widget bottom -->
                <div class="mt-4 bg-[#FCFDFD] border border-gray-150 p-4 rounded-2xl flex items-center justify-between select-none shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm shrink-0 border border-[#C1DDC6]/25">
                            💬
                        </div>
                        <div>
                            <p class="font-extrabold text-[12px] text-gray-900 leading-tight">Need Help?</p>
                            <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Chat with our support team.</p>
                        </div>
                    </div>
                    <a href="{{ route('customer.messages.index') }}" class="bg-white border border-gray-200 hover:border-[#1B7339] text-gray-700 hover:text-[#1B7339] font-bold py-1.5 px-3.5 rounded-xl text-[10px] transition-all select-none">
                        Chat Now
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Form script details parsing -->
<script>
    function selectTimeSlot(slot, element) {
        document.getElementById('selected_time_slot').value = slot;
        
        // Remove active styling from all buttons
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            btn.className = "time-slot-btn border border-gray-200 text-gray-600 bg-white rounded-xl py-2.5 px-3 text-[11px] font-bold hover:border-gray-300 transition-all text-center focus:outline-none select-none";
        });
        
        // Add active styling to clicked button
        element.className = "time-slot-btn border-2 border-[#1B7339] text-[#1B7339] bg-green-50/30 rounded-xl py-2.5 px-3 text-[11px] font-bold transition-all text-center focus:outline-none select-none";
    }

    function updateCharCount(textarea) {
        const len = textarea.value.length;
        document.getElementById('char_counter').textContent = `${len}/200`;
    }

    document.getElementById('booking_form').addEventListener('submit', function(e) {
        const dateVal = document.getElementById('booking_date').value;
        const timeSlot = document.getElementById('selected_time_slot').value;

        // Parse time slot start hour
        let startHour = "09:00:00";
        if (timeSlot.includes("11:00 AM")) {
            startHour = "11:00:00";
        } else if (timeSlot.includes("2:00 PM")) {
            startHour = "14:00:00";
        } else if (timeSlot.includes("4:00 PM")) {
            startHour = "16:00:00";
        }

        // Combine date and time
        const scheduledAt = `${dateVal} ${startHour}`;
        document.getElementById('final_scheduled_at').value = scheduledAt;
    });

    function changeCoverImage(src, element) {
        // Update main cover image
        const coverImg = document.getElementById('service_cover_image');
        if (coverImg) {
            coverImg.src = src;
        }
        
        // Update thumbnail borders
        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.classList.remove('border-[#1B7339]');
            thumb.classList.add('border-gray-100');
        });
        element.classList.add('border-[#1B7339]');
        element.classList.remove('border-gray-100');
    }

</script>
@endsection
