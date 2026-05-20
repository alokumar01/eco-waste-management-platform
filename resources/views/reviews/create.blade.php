@extends('layouts.app')
@section('no_container', true)

@section('content')
<div class="min-h-screen bg-[#F8F9FA] font-sans pb-20 select-none">
    <div class="max-w-[600px] mx-auto px-4 pt-12 space-y-6">
        
        <!-- Back Link -->
        <a href="{{ route('bookings.my') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#3E8B3A] hover:underline mb-2 transition-all group select-none">
            <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to My Bookings</span>
        </a>

        <!-- Main Card -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.015)] space-y-6">
            
            <div>
                <h1 class="text-2xl font-extrabold text-gray-950 tracking-tight leading-none">Rate Your Experience</h1>
                <p class="text-xs text-gray-400 font-semibold mt-2.5">Your honest feedback helps us keep the loop green and verified.</p>
            </div>

            <!-- Service Details Info Block -->
            <div class="bg-[#F8F9FA] border border-gray-100 p-4.5 rounded-2xl flex items-center gap-4 select-none">
                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 select-none">
                    @if ($booking->service->image_path)
                        <img src="{{ asset('storage/' . $booking->service->image_path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#E2E4DE] flex items-center justify-center text-lg text-emerald-800 font-bold select-none">🌱</div>
                    @endif
                </div>
                <div class="space-y-0.5">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Sustainable Service</p>
                    <h4 class="font-extrabold text-xs text-gray-900 leading-tight">{{ $booking->service->name }}</h4>
                    <p class="text-[9.5px] text-gray-400 font-bold uppercase tracking-wider pt-0.5">
                        Provider: <span class="text-[#3E8B3A]">{{ $booking->provider->name }}</span>
                    </p>
                </div>
            </div>

            <!-- Review creation form -->
            <form action="{{ route('reviews.store', $booking) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Interactive Star Select Block -->
                <div class="space-y-2 text-center py-2 bg-gray-50/30 border border-gray-100 rounded-2xl">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Select Rating <span class="text-red-500">*</span></label>
                    
                    <div class="flex items-center justify-center gap-2 pt-1 select-none">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer group relative">
                                <!-- Hidden input radio -->
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required onclick="highlightStars({{ $i }})" {{ old('rating') == $i ? 'checked' : '' }}>
                                
                                <!-- Star SVG trigger -->
                                <svg id="star_icon_{{ $i }}" class="w-10 h-10 star-glyph text-gray-200 fill-current hover:scale-110 active:scale-95 transition-all" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    
                    <!-- Rating verbal indicator badge -->
                    <span id="rating_label" class="inline-block text-[10px] text-gray-400 font-extrabold uppercase tracking-widest pt-1">Click a star to rate</span>

                    @error('rating')
                        <p class="text-red-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment block -->
                <div class="space-y-1.5">
                    <label for="comment" class="block text-[10px] font-extrabold text-gray-600 uppercase tracking-widest">Share Your Experience (Optional)</label>
                    <textarea name="comment" id="comment" rows="4" maxlength="300" placeholder="Tell us about the quality, timeliness, and support..." class="w-full px-4 py-3 border border-gray-200 rounded-2xl text-xs text-gray-700 bg-white focus:outline-none focus:ring-1 focus:ring-[#3E8B3A] focus:border-[#3E8B3A] resize-none" oninput="updateCharCount(this)">{{ old('comment') }}</textarea>
                    <div class="flex justify-between items-center text-[9px] font-bold text-gray-400 select-none pt-0.5">
                        <span>Min 5 characters, Max 300 characters</span>
                        <span id="char_counter">0/300</span>
                    </div>
                    @error('comment')
                        <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Button Block -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-[#3E8B3A] hover:bg-[#2E6F40] text-white font-extrabold py-3.5 rounded-xl text-xs tracking-wider uppercase transition-colors shadow-sm active:scale-[0.99] transform select-none">
                        Submit Review
                    </button>
                    <a href="{{ route('bookings.my') }}" class="px-5 py-3.5 border border-gray-200 hover:bg-gray-50 text-gray-600 font-extrabold rounded-xl text-xs tracking-wider uppercase text-center select-none">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Interactive Star Trigger Logic -->
<script>
    const labels = {
        1: "Extremely Poor 😠",
        2: "Disappointing 🙁",
        3: "Average & Decent 😐",
        4: "Very Good & Clean 🙂",
        5: "Excellent & Green! 🌿"
    };

    function highlightStars(rating) {
        document.getElementById('rating_label').textContent = labels[rating] || "Click a star to rate";
        
        // Loop and paint star fill colors
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star_icon_${i}`);
            if (i <= rating) {
                star.classList.remove('text-gray-200');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-200');
            }
        }
    }

    function updateCharCount(textarea) {
        const len = textarea.value.length;
        document.getElementById('char_counter').textContent = `${len}/300`;
    }

    // Restore selected stars on session errors or page reloads
    document.addEventListener('DOMContentLoaded', () => {
        const checkedRadio = document.querySelector('input[name="rating"]:checked');
        if (checkedRadio) {
            highlightStars(parseInt(checkedRadio.value));
        }
        
        const commentArea = document.getElementById('comment');
        if (commentArea) {
            updateCharCount(commentArea);
        }
    });
</script>
@endsection