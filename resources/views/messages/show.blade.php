@extends('layouts.app')

@if(Auth::user()->role === 'provider')
    @section('no_container', true)
    @section('no_top_nav', true)
@else
    @section('no_container', true)
@endif

@section('content')
@php
    $user = Auth::user();
    
    // Fetch conversations list dynamically inside the blade
    $sentTo = \App\Models\Message::where('sender_id', $user->id)->pluck('receiver_id');
    $receivedFrom = \App\Models\Message::where('receiver_id', $user->id)->pluck('sender_id');
    $userIds = $sentTo->merge($receivedFrom)->unique()->filter(fn($id) => $id != $user->id);
    
    $conversationsList = \App\Models\User::whereIn('id', $userIds)->get()->map(function($otherUser) use ($user) {
        $lastMessage = \App\Models\Message::where(function($q) use ($user, $otherUser) {
            $q->where('sender_id', $user->id)->where('receiver_id', $otherUser->id);
        })->orWhere(function($q) use ($user, $otherUser) {
            $q->where('sender_id', $otherUser->id)->where('receiver_id', $user->id);
        })->latest()->first();
        
        $unreadCount = \App\Models\Message::where('sender_id', $otherUser->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
            
        $otherUser->lastMessage = $lastMessage;
        $otherUser->unreadCount = $unreadCount;
        return $otherUser;
    })->sortByDesc(function($u) {
        return $u->lastMessage ? $u->lastMessage->created_at : now()->subYears(1);
    });

    $totalUnreadCount = $conversationsList->sum('unreadCount');
    
    // Group current chat messages by day
    $groupedMessages = $messages->groupBy(function($message) {
        return $message->created_at->format('Y-m-d');
    });
@endphp

<div class="flex {{ auth()->user()->role === 'provider' ? 'h-screen' : 'h-[calc(100vh-76px)]' }} bg-[#F4F7F6] font-sans overflow-hidden">
    <!-- Sidebar for Providers -->
    @if(auth()->user()->role === 'provider')
        @include('provider-dashboard-sidebar')
    @endif

    <!-- Main Message Center Area Wrapper -->
    <div class="flex-1 flex h-full overflow-hidden bg-white shadow-xl">
        
        <!-- Column 1: Conversations List Sidebar (left 1/3 width) - hidden on mobile when viewing active chat -->
        <div class="w-full md:w-[380px] bg-white border-r border-gray-100 flex flex-col h-full shrink-0 {{ isset($receiver) ? 'hidden md:flex' : 'flex' }}">
            
            <!-- Messages Title Header -->
            <div class="px-5 pt-4 pb-2 flex justify-between items-center select-none shrink-0">
                <h2 class="text-[22px] font-bold text-gray-950 tracking-tight">Messages</h2>
            </div>

            <!-- Search Conversations input bar -->
            <div class="px-4 py-2 select-none shrink-0">
                <div class="relative">
                    <input type="text" id="conversation_search" oninput="searchConversations()" placeholder="Search conversations..." class="w-full pl-9 pr-4 py-2.5 border-0 bg-[#F4F7F6]/80 text-xs font-normal text-gray-700 placeholder-gray-400 rounded-xl focus:ring-1 focus:ring-provider-green focus:outline-none transition-all">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>

            <!-- Active Tab Filter buttons -->
            <div class="px-5 pt-3 select-none flex items-center gap-6 border-b border-gray-100 text-xs font-semibold text-gray-400 shrink-0">
                <button id="tab_all" onclick="filterConversations('all')" class="pb-2.5 border-b-2 border-provider-green text-gray-950 focus:outline-none cursor-pointer">All</button>
                <button id="tab_unread" onclick="filterConversations('unread')" class="pb-2.5 flex items-center gap-1.5 hover:text-gray-600 focus:outline-none cursor-pointer">
                    Unread 
                    @if($totalUnreadCount > 0)
                        <span class="bg-provider-green text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $totalUnreadCount }}</span>
                    @else
                        <span class="bg-gray-100 text-gray-400 text-[9px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                    @endif
                </button>
            </div>

            <!-- Conversations Scrollable Feed -->
            <div class="flex-1 overflow-y-auto divide-y divide-gray-50/40" id="conversations_list_items">
                @forelse($conversationsList as $conv)
                    @php
                        $isActive = isset($receiver) && $receiver->id === $conv->id;
                    @endphp
                    <a href="{{ auth()->user()->role === 'provider' ? route('messages.show', $conv) : route('customer.messages.show', $conv) }}" 
                       class="conv-item flex items-center gap-3.5 px-4 py-3 transition-colors border-l-2 {{ $isActive ? 'bg-provider-green-light/20 border-provider-green' : 'hover:bg-gray-50/50 border-transparent' }}"
                       data-name="{{ strtolower($conv->name) }}"
                       data-unread="{{ $conv->unreadCount }}">
                        
                        <!-- Left Avatar -->
                        <div class="relative shrink-0 select-none">
                            <img src="{{ $conv->profile_picture ? asset('storage/' . $conv->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($conv->name) . '&background=' . ($isActive ? 'eef6ea' : 'fefefe') . '&color=40852b' }}" class="w-11 h-11 rounded-full object-cover border border-gray-100/60">
                        </div>

                        <!-- Middle Details content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5">
                                <p class="font-semibold text-[12px] text-gray-950 truncate leading-none m-0 p-0" style="color: #0E2415;">{{ $conv->name }}</p>
                                <span class="text-[9px] font-semibold text-provider-green bg-provider-green-light px-1 py-0.2 rounded border border-provider-green/20 select-none">Verified</span>
                            </div>
                            <p class="text-[11.5px] text-gray-500 font-normal truncate mt-1.5 leading-tight mb-0">
                                {{ $conv->lastMessage ? $conv->lastMessage->message : 'No messages yet' }}
                            </p>
                        </div>

                        <!-- Right Actions / badges -->
                        <div class="shrink-0 text-right flex flex-col items-end gap-1.5 select-none">
                            @if($conv->lastMessage)
                                <span class="text-[10px] text-gray-400 font-medium leading-none">
                                    {{ $conv->lastMessage->created_at->format('h:i A') }}
                                </span>
                            @endif
                            @if($conv->unreadCount > 0)
                                <span class="bg-provider-green text-white text-[9px] font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-sm">
                                    {{ $conv->unreadCount }}
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="p-12 text-center text-gray-400 select-none space-y-2">
                        <i class="fa-regular fa-comments text-gray-300 text-3xl block"></i>
                        <p class="text-xs font-bold">No chats found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Column 2: Active Chat Room Panel (right 2/3 width) -->
        <div class="flex-1 flex flex-col h-full bg-[#F8FAF9] overflow-hidden {{ isset($receiver) ? 'flex' : 'hidden md:flex' }}">
            
            <!-- Chat Partner top header pane -->
            <div class="py-3 px-6 border-b border-gray-100 flex items-center justify-between bg-white shrink-0 select-none">
                <div class="flex items-center gap-3">
                    <!-- Back button for mobile screens -->
                    <a href="{{ auth()->user()->role === 'provider' ? route('messages.index') : route('customer.messages.index') }}" class="mr-1 text-gray-500 hover:text-gray-800 md:hidden transition-colors">
                        <i class="fa-solid fa-arrow-left text-lg"></i>
                    </a>
                    
                    <!-- Avatar image -->
                    <div class="relative shrink-0">
                        <img src="{{ $receiver->profile_picture ? asset('storage/' . $receiver->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($receiver->name) . '&background=eef6ea&color=40852b' }}" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                    </div>

                    <div class="flex flex-col justify-center">
                        <div class="flex items-center gap-1.5">
                            <p class="font-semibold text-gray-950 leading-none mb-0" style="font-size: 20px !important;">{{ $receiver->name }}</p>
                            <span class="text-[9px] font-medium text-provider-green bg-provider-green-light px-1.5 py-0.5 rounded border border-provider-green/20">Verified</span>
                        </div>
                    </div>
                </div>

                <!-- Right Header Actions (Removed Call / Video Call / Dropdown options entirely) -->
                <div class="flex items-center gap-3">
                    @if($booking)
                        <div class="hidden sm:block text-right">
                            <p class="text-[9px] text-gray-400 uppercase font-semibold tracking-wider leading-none">Related Booking</p>
                            <p class="text-[11.5px] font-semibold text-provider-green mt-1 max-w-[150px] truncate leading-none mb-0">{{ $booking->service->name }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chat Scrollable Messages Area -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="message-container">
                @forelse($groupedMessages as $date => $dayMessages)
                    
                    <!-- Day date stamp pill -->
                    <div class="flex justify-center select-none py-1 shrink-0">
                        <span class="bg-white border border-gray-100/80 px-2 py-1 rounded-2xl text-[10px] text-gray-400 font-semibold shadow-[0_1px_2px_rgba(0,0,0,0.01)] uppercase tracking-wide">
                            {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : (\Carbon\Carbon::parse($date)->isYesterday() ? 'Yesterday' : \Carbon\Carbon::parse($date)->format('M d, Y')) }}
                        </span>
                    </div>

                    @foreach($dayMessages as $message)
                        @if($message->sender_id === auth()->id())
                            <!-- Logged-in Sender Message (Sleek light green style with checkmark double-ticks) -->
                            <div class="flex justify-end" data-message-id="{{ $message->id }}">
                                <div class="max-w-[70%] bg-provider-green-light text-gray-900 rounded-2xl rounded-tr-sm shadow-[0_1px_2px_rgba(0,0,0,0.01)] border border-provider-green/10 px-3.5 py-2.5 space-y-1.5">
                                    <p class="mb-0 text-xs md:text-[13px] font-normal leading-relaxed">{{ $message->message }}</p>
                                    <div class="flex items-center justify-end text-[9.5px] text-provider-green/80 font-medium mt-1 leading-none select-none gap-1">
                                        <span>{{ $message->created_at->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Received Partner Message (Sleek White bubble card layout) -->
                            <div class="flex justify-start" data-message-id="{{ $message->id }}">
                                <div class="max-w-[70%] bg-white text-gray-800 rounded-2xl rounded-tl-sm shadow-[0_1px_3px_rgba(0,0,0,0.02)] border border-gray-100/60 px-3.5 py-2.5 space-y-1.5">
                                    <p class="mb-0 text-xs md:text-[13px] font-normal leading-relaxed">{{ $message->message }}</p>
                                    <div class="flex items-center justify-end text-[9.5px] text-gray-400 font-medium mt-1 leading-none select-none">
                                        {{ $message->created_at->format('h:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @empty
                    <div class="text-center py-20 text-gray-400 select-none space-y-3">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto border border-gray-100 shadow-sm text-gray-300">
                            <i class="fa-solid fa-hand-holding-hand text-lg"></i>
                        </div>
                        <p class="text-xs font-medium">No messages yet. Send a friendly greeting to start!</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input Form (Removed paperclip attachments icon per request) -->
            <div class="p-4 px-6 bg-white border-t border-gray-100 shrink-0">
                <form action="{{ auth()->user()->role === 'provider' ? route('messages.store') : route('customer.messages.store') }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                    @if($booking)
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    @endif
                    
                    <!-- Sleek rounded text message input bar -->
                    <div class="flex-1 relative flex items-center">
                        <input type="text" name="message" required placeholder="Type a message..." 
                               class="w-full px-4 py-2.5 border border-gray-200 focus:border-provider-green focus:ring-1 focus:ring-provider-green rounded-md text-xs font-normal text-gray-700 bg-gray-50/20 focus:bg-white placeholder-gray-400 transition-all"
                               autocomplete="off">
                    </div>
                    
                    <!-- Circular Send Button icon -->
                    <button type="submit" class="bg-provider-green hover:bg-provider-green-dark text-white flex items-center justify-center shadow-md hover:scale-105 active:scale-95 transition-all shrink-0 cursor-pointer" style="width: 38px !important; height: 38px !important; border-radius: 9999px !important;">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

<script>
    let lastMessageId = {{ $messages->max('id') ?? 0 }};
    const receiverId = {{ $receiver->id }};
    const messageContainer = document.getElementById('message-container');
    const displayedMessageIds = new Set();
    
    // Register loaded messages
    document.querySelectorAll('[data-message-id]').forEach(el => {
        displayedMessageIds.add(parseInt(el.dataset.messageId));
    });
    
    const fetchUrl = "{{ auth()->user()->role === 'provider' ? route('messages.fetch', $receiver) : route('customer.messages.fetch', $receiver) }}";
    
    // Polling new message events every 2 seconds
    setInterval(function() {
        fetch(fetchUrl + '?last_id=' + lastMessageId, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.status === 401) {
                return { messages: [] };
            }
            return response.json();
        })
        .then(data => {
            if (data && data.messages) {
                data.messages.forEach(msg => {
                    if (!displayedMessageIds.has(msg.id)) {
                        displayedMessageIds.add(msg.id);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                        
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex ' + (msg.is_sent_by_auth ? 'justify-end' : 'justify-start');
                        messageDiv.dataset.messageId = msg.id;
                        
                        if (msg.is_sent_by_auth) {
                            messageDiv.innerHTML = `
                                <div class="max-w-[70%] bg-provider-green-light text-gray-900 rounded-2xl rounded-tr-sm shadow-[0_1px_2px_rgba(0,0,0,0.01)] border border-provider-green/10 p-3.5 space-y-1.5">
                                    <p class="text-xs md:text-[13px] font-normal leading-relaxed">${escapeHtml(msg.message)}</p>
                                    <div class="flex items-center justify-end text-[9.5px] text-provider-green/80 font-medium mt-1 leading-none select-none gap-1">
                                        <span>${msg.created_at}</span>
                                    </div>
                                </div>
                            `;
                        } else {
                            messageDiv.innerHTML = `
                                <div class="max-w-[70%] bg-white text-gray-800 rounded-2xl rounded-tl-sm shadow-[0_1px_3px_rgba(0,0,0,0.02)] border border-gray-100/60 p-3.5 space-y-1.5">
                                    <p class="text-xs md:text-[13px] font-normal leading-relaxed">${escapeHtml(msg.message)}</p>
                                    <div class="flex items-center justify-end text-[9.5px] text-gray-400 font-medium mt-1 leading-none select-none">
                                        ${msg.created_at}
                                    </div>
                                </div>
                            `;
                        }
                        
                        messageContainer.appendChild(messageDiv);
                        messageContainer.scrollTop = messageContainer.scrollHeight;
                    }
                });
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
    }, 2000);
    
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    
    // Auto scroll bottom
    messageContainer.scrollTop = messageContainer.scrollHeight;
    
    // Form AJAX Submission
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const inputField = this.querySelector('input[name="message"]');
        const messageText = inputField.value.trim();
        
        if (!messageText) return;
        
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                inputField.focus();
            }
        })
        .catch(error => console.error('Error sending message:', error));
    });
    
    // Dropdown toggles
    function toggleDropdown(button) {
        event.stopPropagation();
        const container = button.closest('.dropdown-container');
        const menu = container.querySelector('.dropdown-menu');
        
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) m.classList.add('hidden');
        });
        
        menu.classList.toggle('hidden');
    }
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('hidden'));
        }
    });

    let currentFilter = 'all';
    
    function filterConversations(filter) {
        currentFilter = filter;
        const tabAll = document.getElementById('tab_all');
        const tabUnread = document.getElementById('tab_unread');
        
        if (filter === 'all') {
            tabAll.className = 'pb-2.5 border-b-2 border-provider-green text-gray-950 focus:outline-none';
            tabUnread.className = 'pb-2.5 flex items-center gap-1.5 hover:text-gray-600 focus:outline-none';
        } else {
            tabAll.className = 'pb-2.5 hover:text-gray-600 focus:outline-none';
            tabUnread.className = 'pb-2.5 flex items-center gap-1.5 border-b-2 border-provider-green text-gray-950 focus:outline-none';
        }
        
        applySearchAndFilter();
    }
    
    function searchConversations() {
        applySearchAndFilter();
    }
    
    function applySearchAndFilter() {
        const query = document.getElementById('conversation_search').value.toLowerCase().trim();
        document.querySelectorAll('.conv-item').forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const unread = parseInt(item.getAttribute('data-unread') || '0', 10);
            
            const matchesSearch = name.includes(query);
            const matchesFilter = (currentFilter === 'all') || (currentFilter === 'unread' && unread > 0);
            
            if (matchesSearch && matchesFilter) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }
</script>
@endsection
