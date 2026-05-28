<!-- Sidebar -->
<aside class="w-[260px] bg-[#fdfdfd] border-r border-gray-100 text-gray-900 flex flex-col justify-between shrink-0 h-full overflow-y-auto hidden md:flex">
    <div>
        <!-- Logo Section -->
        <div class="mb-5 px-6 pt-6">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop" class="w-[180px] h-auto object-contain select-none pointer-events-none" draggable="false">
            </a>
        </div>

        <!-- Platform Section -->
        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider px-6 mb-1.5">PLATFORM</h3>
        <nav class="flex flex-col gap-0.5 text-[13px] font-semibold px-3">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-7-4h4m-4 4h4m-4-4h4"></path></svg>
                <span>Dashboard</span>
            </a>
            
            <!-- Providers -->
            <a href="{{ route('admin.providers') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.providers') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span>Providers</span>
            </a>

            <!-- Services -->
            <a href="{{ route('services.list') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('services.list') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4.667 4H15m0 0H9m5.998 0a2 2 0 11-4 0v-.5"></path></svg>
                <span>Services</span>
            </a>

            <!-- Reviews -->
            <a href="{{ route('admin.reviews') }}" 
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.reviews') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span>Reviews</span>
            </a>
        </nav>

        <!-- Content Section -->
        <div class="mt-4">
            <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider px-6 mb-1.5">CONTENT</h3>
            <nav class="flex flex-col gap-0.5 text-[13px] font-semibold px-3">
                <!-- Create Article -->
                <a href="{{ route('blog.create') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('blog.create') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                    <i class="fa-solid fa-pen-to-square text-sm shrink-0 w-4"></i>
                    <span>Create Blog</span>
                </a>
                
                <!-- My Articles -->
                <a href="{{ route('blog.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('blog.index') || request()->routeIs('blog.edit') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                    <i class="fa-solid fa-book-open text-sm shrink-0 w-4"></i>
                    <span>My Articles</span>
                </a>

                <!-- Moderate All Articles -->
                <a href="{{ route('admin.blog.all-articles') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.blog.all-articles') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                    <i class="fa-solid fa-list-check text-sm shrink-0 w-4"></i>
                    <span>All Articles</span>
                </a>
            </nav>
        </div>

        <!-- Settings Section -->
        <div class="mt-4">
            <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider px-6 mb-1.5">SYSTEM</h3>
            <nav class="flex flex-col gap-0.5 text-[13px] font-semibold px-3">
                <!-- Profile -->
                <a href="{{ route('admin.profile.edit') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.profile.edit') ? 'bg-provider-green-light text-provider-green shadow-sm' : 'text-gray-600 hover:bg-provider-green-light hover:text-provider-green' }}">
                    <i class="fa-solid fa-user-gear text-sm shrink-0 w-4"></i>
                    <span>My Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full mt-1">
                    @csrf
                    <button type="submit" class="flex items-center w-full gap-3 px-4 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-provider-green-light hover:text-provider-green text-left cursor-pointer">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Sprout Graphic Card (Provider Style) -->
    <div class="p-4 mt-2">
         <div class="bg-provider-green-light p-4 rounded-2xl text-center border border-green-100 relative overflow-hidden">
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-provider-green opacity-5 translate-x-4 translate-y-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            <div class="relative z-10 flex flex-col items-center">
                <svg class="mb-2 w-10 h-10 text-provider-green" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M32 48C32 48 24 40 22 30C20 20 28 16 32 20" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M32 48C32 48 40 40 42 30C44 20 36 16 32 20" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M32 20V52" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M24 52H40" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>
                <h3 class="font-bold text-gray-900 text-xs mb-1 leading-snug">Platform Analytics</h3>
                <p class="text-[10px] text-gray-500 leading-tight mb-3">Monitor user trends and platform operations.</p>
                <a href="#" onclick="alert('Demo: Exporting System Analytics Reports...')" class="w-full py-2 bg-provider-green-dark hover:bg-black text-white text-[11px] font-bold rounded-xl transition-colors shadow-sm select-none">
                    Export Reports
                </a>
            </div>
        </div>
    </div>
</aside>
