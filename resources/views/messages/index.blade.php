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
@endphp

<div class="flex {{ auth()->user()->role === 'provider' ? 'h-screen' : 'h-[calc(100vh-76px)]' }} bg-[#F4F7F6] font-sans overflow-hidden">
    <!-- Sidebar for Providers -->
    @if(auth()->user()->role === 'provider')
        @include('provider-dashboard-sidebar')
    @endif

    <!-- Main Message Center Area Wrapper -->
    <div class="flex-1 flex h-full overflow-hidden bg-white shadow-xl">
        
        <!-- Column 1: Conversations List Sidebar (left 1/3 width) -->
        <div class="w-full md:w-[380px] bg-white border-r border-gray-100 flex flex-col h-full shrink-0">
            
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
                    <a href="{{ auth()->user()->role === 'provider' ? route('messages.show', $conv) : route('customer.messages.show', $conv) }}" 
                       class="conv-item flex items-center gap-3.5 px-4 py-3 transition-colors border-l-2 border-transparent hover:bg-gray-50/50"
                       data-name="{{ strtolower($conv->name) }}"
                       data-unread="{{ $conv->unreadCount }}">
                        
                        <!-- Left Avatar -->
                        <div class="relative shrink-0 select-none">
                            <img src="{{ $conv->profile_picture ? asset('storage/' . $conv->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($conv->name) . '&background=fefefe&color=40852b' }}" class="w-11 h-11 rounded-full object-cover border border-gray-100/60">
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

        <!-- Column 2: Blank Conversation State (right 2/3 width) -->
        <div class="hidden md:flex flex-1 flex-col justify-center items-center bg-[#F8FAF9] select-none text-center p-8">
            <div class="max-w-sm space-y-4">
                <div class="w-16 h-16 rounded-3xl bg-[#E8F5E9] text-provider-green flex items-center justify-center mx-auto shadow-sm">
                    <i class="fa-regular fa-comments text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-gray-900">Your Chat Rooms</h3>
                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">Select a user conversation from the left sidebar panel to begin unified green-waste service chats.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
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
