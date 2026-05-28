<div class="bg-white border border-gray-100 rounded-2xl p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-fire text-green-theme text-xs"></i>
        <h3 class="font-bold text-gray-900">Popular Articles</h3>
    </div>
    <div class="space-y-4">
        @foreach ($popularPosts as $article)
            <a href="{{ route('public.blog.show', $article->slug) }}" class="flex gap-4 group items-start">
                <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0 bg-gray-100">
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-bold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 leading-snug">{{ $article->title }}</div>
                    <div class="text-[11px] text-gray-500 mt-1">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
