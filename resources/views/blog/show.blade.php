@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('content')
    @if(isset($isPreview) && $isPreview)
        <div class="bg-amber-50 border border-amber-200 py-3 px-4 text-center text-xs font-bold text-amber-800 flex items-center justify-center gap-2 mb-4 rounded-xl max-w-[1400px] mx-auto">
            <i class="fa-solid fa-triangle-exclamation text-sm text-amber-600"></i>
            <span>Preview Mode: This is a preview of your blog article (status: <span class="capitalize text-amber-900">{{ $post->status }}</span>). It is not visible to the public.</span>
        </div>
    @endif
    <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-6">
        <a href="{{ url('/blog') }}" class="text-sm text-green-700 font-medium flex items-center gap-2 hover:text-green-900 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to Blog
        </a>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-9">
                @include('blog.post.article')
            </div>
            <div class="lg:col-span-3">
                <div class="sticky top-24 flex flex-col gap-6">
                    @include('blog.post.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
