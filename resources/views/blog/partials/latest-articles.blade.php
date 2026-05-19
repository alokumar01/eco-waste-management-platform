<div>
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-clock text-green-theme text-xs"></i>
        <h2 class="text-lg font-bold text-gray-900">Latest Articles</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($posts as $post)
            <a href="{{ route('public.blog.show', $post->slug) }}" class="bg-white border border-gray-100 rounded-xl p-3 flex flex-col hover:shadow-md transition-shadow group cursor-pointer block text-left">
                <div class="relative overflow-hidden rounded-lg mb-3">
                    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <span class="text-green-theme text-[10px] font-semibold uppercase mb-1 bg-green-50 self-start px-2 py-0.5 rounded">{{ $post->category }}</span>
                <h4 class="font-bold text-sm text-gray-900 mb-3 flex-grow group-hover:text-green-theme transition-colors">{{ $post->title }}</h4>
                <div class="flex items-center gap-2 mt-auto">
                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-[10px]">
                        {{ substr($post->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-[11px] font-semibold text-gray-900">{{ $post->user->name ?? 'Admin' }}</div>
                        <div class="text-[10px] text-gray-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }} • 5 min read</div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="flex justify-center mt-6">
        <button class="bg-white border border-gray-200 text-gray-700 text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-gray-50 transition-colors flex items-center gap-2 shadow-sm">
            Load More Articles <i class="fa-solid fa-chevron-down text-xs"></i>
        </button>
    </div>
</div>
