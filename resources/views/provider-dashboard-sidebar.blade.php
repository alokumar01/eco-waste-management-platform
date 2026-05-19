<div class="w-[260px] bg-[#0E3E26] text-white flex flex-col justify-between shrink-0 h-full overflow-y-auto hidden md:flex">
    <div>
        <div class="mb-5 px-6 pt-6">
            <a href="{{ route('provider.dashboard') }}" class="block">
                <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop" class="w-[180px] h-auto object-contain select-none pointer-events-none" draggable="false">
            </a>
        </div>
        
        <h3 class="text-[10px] font-bold text-[#6D9B82] uppercase tracking-wider px-6 mb-1.5">MAIN MENU</h3>
        <nav class="flex flex-col gap-0.5 text-[13px] font-medium px-3">
            <a href="{{ route('provider.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('provider.dashboard') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-7-4h4m-4 4h4m-4-4h4"></path></svg>
                <span>Dashboard</span>
            </a>
            @if(Auth::user()->is_verified)
                <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('services.*') && !request()->routeIs('services.create') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    <span>My Services</span>
                </a>
                <a href="{{ route('services.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('services.create') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Service</span>
                </a>
                <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('bookings.*') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Bookings</span>
                </a>
                <a href="{{ route('blog.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('blog.create') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Create Blog Post</span>
                </a>
                <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('blog.index') || request()->routeIs('blog.edit') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 4v6h6M9 12h6M9 16h6"></path></svg>
                    <span>My Articles</span>
                </a>
                <a href="{{ route('reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('reviews.*') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span>Reviews</span>
                </a>
                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('messages.*') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>Messages</span>
                </a>
            @else
                <div class="px-6 py-2 text-xs text-[#6D9B82] italic">
                    Unlock features after verification
                </div>
            @endif
        </nav>
        
        <div class="mt-4">
            <h3 class="text-[10px] font-bold text-[#6D9B82] uppercase tracking-wider px-6 mb-1.5">ACCOUNT</h3>
            <nav class="flex flex-col gap-0.5 text-[13px] font-medium px-3">
                <a href="{{ route('provider.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('provider.profile.*') ? 'bg-[#215E39] text-white shadow-sm' : 'text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Profile</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4c0-1.165.46-2.223 1.228-3z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c0 3.536-2.362 6.437-5.443 7.126C7.936 19.69 8.89 20 10 20c4.418 0 8-3.582 8-8s-3.582-8-8-8c-1.11 0-2.174.225-3.161.633"></path></svg>
                    <span>Help & Support</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full mt-1">
                    @csrf
                    <button type="submit" class="flex items-center w-full gap-3 px-4 py-2.5 rounded-xl transition-colors text-[#A0BDB0] hover:bg-[#164D2E] hover:text-white">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>
    
    <div class="p-4 mt-2">
         <div class="bg-[#1C5938] p-3 py-4 rounded-xl text-center shadow-inner relative overflow-hidden">
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-white opacity-5 translate-x-4 translate-y-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            <img src="{{ asset('images/earth-care.svg') }}" alt="Earth Care" class="mx-auto mb-2 w-7 h-7 opacity-90 relative z-10 brightness-0 invert">
            <h3 class="font-bold text-white text-[11px] mb-0.5 leading-snug relative z-10">Every Service Makes a Difference</h3>
            <p class="text-[9px] text-[#A6E3B8] leading-tight relative z-10">Thank you for keeping the planet clean and green.</p>
        </div>
    </div>
</div>
