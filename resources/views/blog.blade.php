@extends(Auth::check() ? 'layouts.app' : 'layouts.public_wrapper')

@section('content')
    <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-9 flex flex-col gap-6">
            @include('blog.partials.hero')
            @include('blog.partials.featured-article')
            @include('blog.partials.latest-articles')
        </div>
        <div class="lg:col-span-3 flex flex-col gap-6">
            @include('blog.partials.categories')
            @include('blog.partials.popular-articles')
            @include('blog.partials.subscribe')
        </div>
    </div>
@endsection
