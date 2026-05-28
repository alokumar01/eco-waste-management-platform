<!-- Header -->
<header class="h-20 bg-white border-b border-gray-100 px-8 flex items-center justify-between shrink-0">
    <!-- Left Header -->
    <div class="flex items-center gap-4">
        <button class="text-gray-400 hover:text-gray-700">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

    </div>

    <!-- Right Header -->
    <div class="flex items-center gap-6">
        <!-- Notification Bell -->
        <button class="relative text-gray-400 hover:text-gray-700">
            <i class="fa-regular fa-bell text-lg"></i>
            <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white rounded-full text-[9px] font-bold flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
        </button>
        <!-- Messages -->
        <button class="text-gray-400 hover:text-gray-700">
            <i class="fa-regular fa-comment-dots text-lg"></i>
        </button>
        <!-- Vertical Divider -->
        <div class="w-px h-6 bg-gray-200"></div>
        <!-- Profile details -->
        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 hover:opacity-85 transition-opacity group">
            @if(Auth::user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover group-hover:scale-105 transition-transform">
            @else
                <div class="w-9 h-9 rounded-full bg-[#E8F5E9] text-[#2E6F40] font-extrabold text-[13px] flex items-center justify-center group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            @endif
            <div class="text-left leading-tight hidden md:block">
                <h4 class="text-[12px] font-extrabold text-gray-900 group-hover:text-[#2E6F40] transition-colors">{{ Auth::user()->name ?? 'Admin' }}</h4>
                <p class="text-[10px] text-gray-400 font-medium">Administrator</p>
            </div>
        </a>
    </div>
</header>
