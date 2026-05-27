@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#FAFCFB] font-sans overflow-hidden">
    @include('admin-dashboard-sidebar')

    <!-- Main Content Panel -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('admin-dashboard-header')

        <!-- Scrollable content -->
        <main class="flex-1 overflow-y-auto p-8 bg-[#FAFCFB] space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">All Articles</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Manage and moderate all blog posts created by providers and administrators.</p>
                </div>
                <a href="{{ route('blog.create') }}" class="px-4 py-2.5 bg-[#1A4D2E] hover:bg-green-900 text-white text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-1.5 self-start">
                    <i class="fa-solid fa-plus text-xs"></i> Create Admin Post
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Articles Moderation List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">Moderate Blog Posts</h3>
                    <span class="text-xs bg-[#E8F5E9] text-[#2E6F40] font-bold px-2.5 py-1 rounded-full">{{ $articles->count() }} Posts</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/40 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider select-none">
                                <th class="px-6 py-4">Title & Author</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Visibility</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-xs text-gray-600">
                            @forelse($articles as $article)
                                <tr class="hover:bg-[#FAFCFB] transition-colors">
                                    <!-- Title & Author -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($article->featured_image)
                                                <img src="{{ asset('storage/' . $article->featured_image) }}" class="w-10 h-7 rounded object-cover border border-gray-100">
                                            @else
                                                <div class="w-10 h-7 rounded bg-gray-100 flex items-center justify-center border border-gray-100">
                                                    <i class="fa-regular fa-image text-gray-400 text-xs"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('provider.blog.preview', $article->id) }}" target="_blank" class="font-extrabold text-gray-900 hover:text-[#2E6F40] transition-colors line-clamp-1">
                                                    {{ $article->title }}
                                                </a>
                                                <div class="flex items-center gap-1.5 mt-0.5 text-[10px] text-gray-400 font-bold">
                                                    <span>By {{ $article->author->name ?? 'Unknown' }}</span>
                                                    <span class="px-1.5 py-0.2 bg-gray-150 rounded text-[8.5px] uppercase tracking-wide">
                                                        {{ $article->author->role ?? 'Provider' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="px-6 py-4 font-semibold text-gray-500">
                                        {{ $article->category }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('admin.blog.toggle-status', $article->id) }}" class="inline-block">
                                            @csrf
                                            @if($article->status === 'published')
                                                <button type="submit" class="inline-flex items-center gap-1.5 bg-[#E8F5E9] text-[#2E6F40] text-[10px] font-extrabold px-2.5 py-1 rounded-full cursor-pointer hover:bg-green-100 transition-colors">
                                                    <i class="fa-solid fa-circle text-[6px]"></i> Published
                                                </button>
                                            @else
                                                <button type="submit" class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 text-[10px] font-extrabold px-2.5 py-1 rounded-full cursor-pointer hover:bg-gray-200 transition-colors">
                                                    <i class="fa-solid fa-circle text-[6px] text-gray-400"></i> Draft
                                                </button>
                                            @endif
                                        </form>
                                    </td>

                                    <!-- Visibility -->
                                    <td class="px-6 py-4 uppercase font-bold text-[10px] text-gray-400 tracking-wider">
                                        {{ $article->visibility ?? 'public' }}
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 font-semibold text-gray-400">
                                        {{ $article->created_at->format('M d, Y') }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('provider.blog.preview', $article->id) }}" target="_blank"
                                               class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-500 hover:text-gray-800 rounded-lg transition-colors"
                                               title="Preview">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('blog.edit', $article->id) }}"
                                               class="p-1.5 bg-gray-50 hover:bg-gray-100 text-gray-500 hover:text-green-700 rounded-lg transition-colors"
                                               title="Edit">
                                                <i class="fa-solid fa-pencil text-xs"></i>
                                            </a>
                                            <form method="POST" action="{{ route('blog.destroy', $article->id) }}" data-confirm="Are you sure you want to delete this blog post?" data-confirm-title="Delete Article" data-confirm-text="Delete" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 rounded-lg transition-colors cursor-pointer" title="Delete">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-semibold">
                                        No articles found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
