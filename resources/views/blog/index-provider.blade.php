@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    @if(auth()->user()->role === 'admin')
        @include('admin-dashboard-sidebar')
    @else
        @include('provider-dashboard-sidebar')
    @endif

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @if(auth()->user()->role === 'admin')
            @include('admin-dashboard-header')
        @else
            @include('provider-dashboard-header')
        @endif

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">My Articles</h1>
                <p class="text-gray-500 text-sm">Manage your blog posts, drafts, and published content.</p>
            </div>
            <a href="{{ route('blog.create') }}" class="bg-[#1A4D2E] text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm hover:bg-green-900 transition-colors">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Write a Post</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($posts->count() > 0)
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($posts as $post)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 max-w-xs truncate">
                                    {{ $post->title }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md text-xs">{{ $post->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($post->status === 'published')
                                        <span class="text-xs font-medium bg-green-100 text-green-700 px-2.5 py-1 rounded-full flex items-center gap-1.5 w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Published
                                        </span>
                                    @else
                                        <span class="text-xs font-medium bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full flex items-center gap-1.5 w-max">
                                            <div class="w-1.5 h-1.5 rounded-full bg-yellow-500"></div> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $post->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('provider.blog.preview', $post->id) }}" target="_blank" title="Preview Article" class="text-gray-400 hover:text-green-600 transition-colors inline-block"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('blog.edit', $post->id) }}" class="text-gray-400 hover:text-green-600 transition-colors inline-block"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ route('blog.destroy', $post->id) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this post? This action cannot be undone." data-confirm-title="Delete Post" data-confirm-text="Delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors bg-transparent border-0 p-0 cursor-pointer">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-regular fa-folder-open text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No articles found</h3>
                    <p class="text-gray-500 text-sm mb-6 max-w-sm">You haven't written any blog posts yet. Start sharing your knowledge with the community!</p>
                    <a href="{{ route('blog.create') }}" class="text-green-700 font-medium hover:text-green-800 text-sm flex items-center gap-2">
                        Write your first post <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection
