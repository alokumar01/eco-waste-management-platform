@php
    $provider = Auth::user();
@endphp
<!-- Top Header Area (Sticky White Navbar Component) -->
<header class="flex justify-between items-center bg-white border-b border-gray-100 px-6 md:px-10 py-3 shrink-0 z-10 select-none">
    <!-- Left: Search Area / Mobile Toggle -->
    <div class="flex items-center gap-4">
        <button class="p-2 text-gray-500 hover:text-gray-700 bg-white rounded-lg shadow-sm md:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div class="relative hidden sm:block w-[300px]">
            <input type="text" placeholder="Search anything..." class="w-full pl-4 pr-10 py-1.5 border border-gray-100 rounded-xl text-sm bg-gray-50/70 focus:bg-white focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all placeholder-gray-400">
            <svg class="w-4 h-4 text-gray-400 absolute right-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Right: Notifications & Profile -->
    <div class="flex items-center gap-4">
        <!-- Action Icons -->
        <div class="flex items-center gap-2">
            <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100/50 transition-colors">
                <svg class="w-6 h-6 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1 right-1 w-4 h-4 bg-[#4CAF50] rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white">3</span>
            </a>
            <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100/50 transition-colors">
                <svg class="w-6 h-6 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span class="absolute top-1 right-1 w-4 h-4 bg-[#4CAF50] rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white">2</span>
            </a>
        </div>

        <!-- Divider Line -->
        <div class="h-8 w-px bg-gray-200/80 mx-1 hidden sm:block"></div>

        <!-- Profile Info -->
        <div class="flex items-center gap-3 pl-1">
            <img src="{{ $provider->profile_picture ? asset('storage/' . $provider->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) . '&background=E8F5E9&color=1B7339' }}" alt="{{ $provider->name }}" class="w-9 h-9 rounded-full object-cover select-none">
            <div class="hidden sm:block text-left select-none">
                <p class="font-bold text-[13px] leading-tight text-gray-900 mb-0">{{ $provider->name }}</p>
                <p class="text-[11px] text-gray-400 font-medium mt-0.5 mb-0">Service Provider</p>
            </div>
            <svg class="w-3.5 h-3.5 text-gray-400 select-none cursor-pointer hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </div>
</header>
