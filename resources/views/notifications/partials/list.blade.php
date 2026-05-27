<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 select-none mb-8">
    <div>
        <h1 class="text-[20px] font-bold text-gray-900 mb-1 tracking-tight leading-none">Notifications</h1>
        <p class="text-[12px] text-gray-500 font-medium mt-2">
            You have {{ auth()->user()->notifications()->whereNull('read_at')->count() }} unread notifications.
        </p>
    </div>
    @if(auth()->user()->notifications()->count() > 0)
        <div class="flex items-center gap-2.5">
            <form action="{{ route('notifications.mark-all-as-read') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-provider-green hover:bg-provider-green-dark text-white text-xs font-bold rounded-lg transition-colors shadow-sm select-none cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Mark All as Read</span>
                </button>
            </form>
            <form action="{{ route('notifications.destroy-all') }}" method="POST" class="inline" data-confirm="Are you sure you want to delete all notifications?" data-confirm-title="Clear Notifications" data-confirm-text="Delete All">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-bold rounded-lg transition-colors shadow-sm select-none cursor-pointer">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                    <span>Clear All</span>
                </button>
            </form>
        </div>
    @endif
</div>

@if (session('success'))
    <div class="bg-provider-green-light border-l-4 border-provider-green text-provider-green p-4 rounded-r-xl shadow-sm select-none mb-6 font-semibold text-xs" role="alert">
        {{ session('success') }}
    </div>
@endif

<!-- Notifications List -->
@if($notifications->count() > 0)
    <div class="space-y-4">
        @foreach($notifications as $notification)
            @php
                $isUnread = $notification->isUnread();
            @endphp
            <div class="bg-white p-5 rounded-xl border border-gray-100/70 shadow-[0_2px_10px_rgba(0,0,0,0.015)] hover:shadow-md transition-all flex items-start justify-between gap-4 border-l-4 {{ $isUnread ? 'border-l-provider-green bg-provider-green-light/20' : 'border-l-gray-200' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-bold text-[13px] text-gray-900 leading-snug">{{ $notification->title }}</h3>
                        @if($isUnread)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase border border-provider-green/20 bg-provider-green-light text-provider-green select-none">
                                New
                            </span>
                        @endif
                    </div>
                    <p class="text-[11.5px] text-gray-500 font-medium mt-1 leading-relaxed">{{ $notification->message }}</p>
                    
                    <div class="flex items-center gap-3 mt-3">
                        <span class="text-[10px] text-gray-400 font-bold select-none flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-days text-[11px]"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if($notification->action_url)
                            <span class="text-gray-300 text-xs select-none">•</span>
                            <a href="{{ $notification->action_url }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-provider-green hover:underline transition-all">
                                <span>View Details</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Actions (Mark Read & Delete) -->
                <div class="flex items-center gap-2 shrink-0 select-none">
                    @if($isUnread)
                        <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Mark as read" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:border-provider-green text-gray-400 hover:text-provider-green bg-white transition-all shadow-sm cursor-pointer">
                                <i class="fa-solid fa-check text-xs"></i>
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete notification" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:border-red-500 text-gray-400 hover:text-red-500 bg-white transition-all shadow-sm cursor-pointer">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pt-6">
        {{ $notifications->links() }}
    </div>
@else
    <!-- Organic Empty State -->
    <div class="bg-white p-16 rounded-2xl border border-dashed border-gray-200 text-center select-none shadow-[0_2px_10px_rgba(0,0,0,0.005)]">
        <div class="w-16 h-16 bg-provider-green-light rounded-xl flex items-center justify-center mx-auto mb-5 text-xl text-provider-green">
            <i class="fa-solid fa-bell"></i>
        </div>
        <h4 class="font-bold text-xs text-gray-900">All caught up!</h4>
        <p class="text-[11px] text-gray-400 mt-1.5 leading-snug">You have no new notifications at the moment.</p>
    </div>
@endif
