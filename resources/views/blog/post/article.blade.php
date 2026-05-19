<article class="prose lg:prose-lg max-w-none text-gray-600">
    <div class="mb-8">
        <span class="text-green-theme text-sm font-semibold bg-green-100 px-3 py-1 rounded-md">{{ $post->category }}</span>
        <h1 class="mt-4 text-3xl md:text-4xl font-bold text-gray-900">{{ $post->title }}</h1>
        <p class="lead mt-4 text-lg">{{ $post->excerpt }}</p>
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mt-6">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                    {{ substr($post->user->name ?? 'A', 0, 1) }}
                </div>
                <span class="font-semibold text-gray-900">{{ $post->user->name ?? 'Admin' }}</span>
            </div>
            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
            @if($post->tags)
                <div class="flex gap-2 ml-4">
                    @foreach($post->tags as $tag)
                        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
            <div class="ml-auto flex items-center gap-2 text-gray-500 w-full md:w-auto mt-4 md:mt-0">
                <span class="text-sm font-medium mr-1">Share:</span>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-600 hover:bg-gray-100 transition-colors"><i class="fab fa-facebook-f text-xs"></i></a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-400 hover:bg-gray-100 transition-colors"><i class="fab fa-twitter text-xs"></i></a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-700 hover:bg-gray-100 transition-colors"><i class="fab fa-linkedin-in text-xs"></i></a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-green-600 hover:bg-gray-100 transition-colors"><i class="fa-solid fa-link text-xs"></i></a>
            </div>
        </div>
    </div>
    
    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" class="rounded-2xl my-8 w-full object-cover" style="max-height: 450px;">
    @else
        <img src="https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="rounded-2xl my-8 w-full object-cover" style="max-height: 450px;">
    @endif

    <div class="space-y-6">
        {!! $post->content !!}
    </div>
</article>
