@php
    $provider = Auth::user();
    $unreadNotificationsCount = $provider->notifications()->whereNull('read_at')->count();
    $unreadMessagesCount = \App\Models\Message::where('receiver_id', $provider->id)->whereNull('read_at')->count();
@endphp
<!-- Top Header Area (Sticky White Navbar Component) -->
<header class="flex justify-between items-center bg-white border-b border-gray-100 px-6 md:px-10 py-3 shrink-0 z-10 select-none">
    <!-- Left: Search Area / Mobile Toggle -->
    <div class="flex items-center gap-4">
        <button class="p-2 text-gray-500 hover:text-gray-700 bg-white rounded-lg shadow-sm md:hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

    </div>

    <!-- Right: Notifications & Profile -->
    <div class="flex items-center gap-4">
        <!-- Action Icons -->
        <div class="flex items-center gap-2">
            <!-- Notification Bell -->
            <div class="relative provider-dropdown-container">
                <button id="providerNotificationBtn" class="relative p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100/50 transition-colors focus:outline-none cursor-pointer">
                    <svg class="w-6 h-6 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if($unreadNotificationsCount > 0)
                        <span id="providerNotificationBadge" class="absolute top-1 right-1 w-4 h-4 bg-provider-green rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white">{{ $unreadNotificationsCount }}</span>
                    @else
                        <span id="providerNotificationBadge" class="absolute top-1 right-1 w-4 h-4 bg-provider-green rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white hidden"></span>
                    @endif
                </button>
                
                <!-- Notification Dropdown -->
                <div id="providerNotificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 transform origin-top-right transition-all">
                    <div class="p-4 flex items-center justify-between border-b border-gray-100">
                        <h3 class="font-bold text-gray-900 text-xs">Notifications</h3>
                        <a href="{{ route('notifications.index') }}" class="text-[11px] font-extrabold text-provider-green hover:text-provider-green-dark">View All</a>
                    </div>
                    <div id="providerNotificationList" class="max-h-80 overflow-y-auto">
                        <div class="p-6 text-center text-xs text-gray-500">Loading notifications...</div>
                    </div>
                    <form action="{{ route('notifications.mark-all-as-read') }}" method="POST" class="border-t border-gray-100">
                        @csrf
                        <button type="submit" class="w-full p-3 text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors text-center cursor-pointer">
                            Mark All as Read
                        </button>
                    </form>
                </div>
            </div>

            <!-- Messages Icon -->
            <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100/50 transition-colors">
                <svg class="w-6 h-6 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                @if($unreadMessagesCount > 0)
                    <span class="absolute top-1 right-1 w-4 h-4 bg-provider-green rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
        </div>

        <!-- Divider Line -->
        <div class="h-8 w-px bg-gray-200/80 mx-1 hidden sm:block"></div>

        <!-- Profile Info -->
        <div class="flex items-center gap-3 pl-1">
            <img src="{{ $provider->profile_picture ? asset('storage/' . $provider->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) . '&background=eef6ea&color=40852b' }}" alt="{{ $provider->name }}" class="w-9 h-9 rounded-full object-cover select-none">
            <div class="hidden sm:block text-left select-none">
                <p class="font-bold text-[13px] leading-tight text-gray-900 mb-0">{{ $provider->name }}</p>
                <p class="text-[11px] text-gray-400 font-medium mt-0.5 mb-0">Service Provider</p>
            </div>
            <svg class="w-3.5 h-3.5 text-gray-400 select-none cursor-pointer hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notifBtn = document.getElementById('providerNotificationBtn');
        const notifDropdown = document.getElementById('providerNotificationDropdown');

        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
                
                // If opening, load notifications
                if (!notifDropdown.classList.contains('hidden')) {
                    loadProviderNotifications();
                }
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.provider-dropdown-container')) {
                    notifDropdown.classList.add('hidden');
                }
            });
        }

        function loadProviderNotifications() {
            fetch('{{ route("notifications.recent") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    return { notifications: [] };
                }
                return response.json();
            })
            .then(data => {
                const notificationList = document.getElementById('providerNotificationList');
                
                if (!data.notifications || data.notifications.length === 0) {
                    notificationList.innerHTML = '<div class="p-6 text-center text-xs text-gray-500">No notifications</div>';
                    return;
                }

                let html = '';
                data.notifications.forEach(notification => {
                    const readClass = notification.read_at ? 'bg-white' : 'bg-provider-green-light/20';
                    const newBadge = notification.read_at ? '' : '<span class="w-2 h-2 rounded-full bg-provider-green mt-1 shrink-0"></span>';
                    
                    html += `
                        <a href="${notification.action_url || '#'}" class="block p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors ${readClass}">
                            <div class="flex justify-between items-start gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-gray-900 leading-snug">${notification.title}</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2">${notification.message}</p>
                                    <p class="text-[9px] text-gray-400 font-bold mt-1.5 flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar-days text-[10px]"></i>
                                        ${new Date(notification.created_at).toLocaleDateString()}
                                    </p>
                                </div>
                                ${newBadge}
                            </div>
                        </a>
                    `;
                });
                
                notificationList.innerHTML = html;
            })
            .catch(error => console.error('Error loading provider notifications:', error));
        }

        // Live polling unread count
        function updateProviderUnreadCount() {
            fetch('{{ route("notifications.unread-count") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    return { unread_count: 0 };
                }
                return response.json();
            })
            .then(data => {
                const badge = document.getElementById('providerNotificationBadge');
                if (badge) {
                    if (data && data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            })
            .catch(error => console.error('Error updating provider unread count:', error));
        }

        setInterval(updateProviderUnreadCount, 10000);
    });
</script>
