<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left side (Logo & Main Links) -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('icon-landscap.svg') }}" alt="Logo" style="height: 2.5rem; width: auto; object-fit: contain;">
                        <div class="flex flex-col">
                            @auth
                                @if(Auth::user()->role === 'provider')
                                    <span class="text-[10px] text-gray-500 font-semibold tracking-wider uppercase leading-tight">Provider Hub</span>
                                @else
                                    <span class="text-[10px] text-gray-500 font-semibold tracking-wider uppercase leading-tight">Customer Portal</span>
                                @endif
                            @endauth
                        </div>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden sm:flex sm:items-center ml-8" style="gap: 1.5rem;">
                    @auth
                        @if(Auth::user()->role === 'provider')
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Dashboard</a>
                            <a href="{{ route('services.index') }}" class="text-sm font-medium {{ request()->routeIs('services.*') && !request()->routeIs('services.list') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">My Services</a>
                            <a href="{{ route('bookings.index') }}" class="text-sm font-medium {{ request()->routeIs('bookings.*') && !request()->routeIs('bookings.my') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Bookings</a>
                            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Earnings</a>
                            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Reviews</a>
                            <a href="{{ route('blog.index') }}" class="text-sm font-medium {{ request()->routeIs('blog.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Blog Posts</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Dashboard</a>
                            <a href="{{ route('services.list') }}" class="text-sm font-medium {{ request()->routeIs('services.list') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Browse Services</a>
                            <a href="{{ route('bookings.my') }}" class="text-sm font-medium {{ request()->routeIs('bookings.my') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">My Bookings</a>
                            <a href="{{ route('customer.messages.index') }}" class="text-sm font-medium {{ request()->routeIs('customer.messages.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Messages</a>
                            <a href="{{ route('public.blog.index') }}" class="text-sm font-medium {{ request()->routeIs('public.blog.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Blog</a>
                        @endif
                    @else
                        <a href="{{ url('/') }}" class="text-sm font-medium {{ request()->is('/') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Home</a>
                        <a href="{{ route('services.list') }}" class="text-sm font-medium {{ request()->routeIs('services.list') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Services</a>
                        <a href="{{ route('public.blog.index') }}" class="text-sm font-medium {{ request()->routeIs('public.blog.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900 transition-colors' }}">Blog</a>
                    @endauth
                </div>
            </div>

            <!-- Right side (Search, Icons, Profile) -->
            <div class="flex items-center gap-4">
                
                @auth
                    <!-- Search Bar -->
                    <div class="hidden md:flex relative mr-2">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" placeholder="Search anything..." class="w-48 lg:w-64 pl-9 pr-4 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:bg-white transition-colors">
                    </div>

                    <!-- Icons -->
                    <div class="flex items-center gap-2 mr-2">
                        <!-- Notification Bell -->
                        <div class="relative nav-dropdown-container">
                            <button id="notificationBtn" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-600 transition-colors relative">
                                <i class="fa-regular fa-bell"></i>
                                <span id="notificationBadge" class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white hidden"></span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 transform origin-top-right transition-all">
                                <div class="p-4 flex items-center justify-between border-b border-gray-100">
                                    <h3 class="font-bold text-gray-900">Notifications</h3>
                                    <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-green-600 hover:text-green-800">View All</a>
                                </div>
                                <div id="notificationList" class="max-h-80 overflow-y-auto">
                                    <div class="p-6 text-center text-sm text-gray-500">Loading notifications...</div>
                                </div>
                                <form action="{{ route('notifications.mark-all-as-read') }}" method="POST" class="border-t border-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full p-3 text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors text-center">
                                        Mark All as Read
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Messages Icon -->
                        <a href="{{ Auth::user()->role === 'provider' ? '#' : route('customer.messages.index') }}" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-600 transition-colors relative">
                            <i class="fa-regular fa-comment-dots"></i>
                        </a>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative nav-dropdown-container">
                        <button id="profileBtn" class="flex items-center gap-2 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold overflow-hidden border border-green-200 shrink-0">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="hidden md:flex flex-col items-start mr-1 text-left">
                                <span class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-gray-500 mt-0.5">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                        </button>
                        
                        <!-- Profile Menu -->
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 transform origin-top-right transition-all">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors flex items-center gap-2">
                                    <i class="fa-regular fa-user w-4"></i> Profile
                                </a>
                                @if(Auth::user()->role === 'provider')
                                <a href="{{ route('provider.profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-store w-4"></i> Business Settings
                                </a>
                                @endif
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition-colors shadow-sm">Sign up</a>
                    </div>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button class="sm:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown Toggle Logic
        const dropdownContainers = document.querySelectorAll('.nav-dropdown-container');
        
        dropdownContainers.forEach(container => {
            const btn = container.querySelector('button');
            const dropdown = container.querySelector('div[id$="Dropdown"]');
            
            if(btn && dropdown) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Close all others first
                    document.querySelectorAll('div[id$="Dropdown"]').forEach(d => {
                        if(d !== dropdown) d.classList.add('hidden');
                    });
                    // Toggle current
                    dropdown.classList.toggle('hidden');
                });
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('div[id$="Dropdown"]').forEach(d => {
                d.classList.add('hidden');
            });
        });

        // Notification Logic
        @auth
            loadNotifications();
            updateUnreadCount();
            
            setInterval(updateUnreadCount, 10000);

            const notifBtn = document.getElementById('notificationBtn');
            if(notifBtn) {
                notifBtn.addEventListener('click', loadNotifications);
            }

            function loadNotifications() {
                fetch('{{ route("notifications.recent") }}')
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notificationList');
                        
                        if (data.notifications.length === 0) {
                            notificationList.innerHTML = '<div class="p-6 text-center text-sm text-gray-500">No notifications</div>';
                            return;
                        }

                        let html = '';
                        data.notifications.forEach(notification => {
                            const readClass = notification.read_at ? 'bg-white' : 'bg-green-50';
                            const newBadge = notification.read_at ? '' : '<span class="w-2 h-2 rounded-full bg-green-500 mt-1 shrink-0"></span>';
                            
                            html += `
                                <a href="${notification.action_url || '#'}" class="block p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors ${readClass}">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">${notification.title}</p>
                                            <p class="text-xs text-gray-600 mt-0.5 line-clamp-2">${notification.message}</p>
                                            <p class="text-[10px] text-gray-400 mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        ${newBadge}
                                    </div>
                                </a>
                            `;
                        });
                        
                        notificationList.innerHTML = html;
                    })
                    .catch(error => console.error('Error loading notifications:', error));
            }

            function updateUnreadCount() {
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notificationBadge');
                        if (data.unread_count > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error updating unread count:', error));
            }
        @endauth
    });
</script>
