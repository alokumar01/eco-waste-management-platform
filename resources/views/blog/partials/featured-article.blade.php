@if($featuredPost)
<div>
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-star text-green-theme text-xs"></i>
        <h2 class="text-lg font-bold text-gray-900">Featured Article</h2>
    </div>
    <div class="bg-green-tint border border-green-50 rounded-2xl p-4 flex flex-col md:flex-row gap-6 hover:shadow-md transition-shadow">
        <div class="w-full md:w-1/2">
            <img src="{{ $featuredPost->featured_image ? asset('storage/' . $featuredPost->featured_image) : 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $featuredPost->title }}" class="w-full h-64 object-cover rounded-xl shadow-sm">
        </div>
        <div class="w-full md:w-1/2 flex flex-col justify-center">
            <span class="text-green-theme text-xs font-semibold uppercase tracking-wider mb-2">{{ $featuredPost->category }}</span>
            <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-snug">{{ $featuredPost->title }}</h3>
            <p class="text-gray-600 text-sm mb-6">{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 120) }}</p>
            <div class="flex items-center justify-between mt-auto">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs">
                        {{ substr($featuredPost->author->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-900">{{ $featuredPost->author->name ?? 'Admin' }}</div>
                        <div class="text-[11px] text-gray-500">{{ $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : $featuredPost->created_at->format('M d, Y') }} • 5 min read</div>
                    </div>
                </div>
                <a href="{{ route('public.blog.show', $featuredPost->slug) }}" class="bg-green-theme text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-green-900 transition-colors flex items-center gap-2">
                    Read Full Article <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endif
