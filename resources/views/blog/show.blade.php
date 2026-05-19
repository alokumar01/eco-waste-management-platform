@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('content')
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
