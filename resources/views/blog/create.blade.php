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

            <!-- Page Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Create Blog Post</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Share your knowledge and help build a more sustainable community.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to My Articles
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm text-sm">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="blog-post-form" action="{{ url('provider/blog') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Left: Main Form (2/3) -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Block 1: Article Details -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Article Details</h2>

                            <!-- Title -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Title <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="title" required placeholder="Enter an engaging title for your article" maxlength="150"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700"
                                        value="{{ old('title') }}" id="blog_title">
                                    <span id="title_counter" class="absolute right-4 top-1/2 -translate-y-1/2 text-[9.5px] font-bold text-gray-400">0/150</span>
                                </div>
                            </div>

                            <!-- Category & Tags -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Category <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-green-600 pointer-events-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        </div>
                                        <select name="category" required class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 appearance-none text-gray-700">
                                            <option value="" disabled selected>Select category</option>
                                            <option value="Composting" {{ old('category') == 'Composting' ? 'selected' : '' }}>Composting</option>
                                            <option value="Waste Management" {{ old('category') == 'Waste Management' ? 'selected' : '' }}>Waste Management</option>
                                            <option value="Sustainability" {{ old('category') == 'Sustainability' ? 'selected' : '' }}>Sustainability</option>
                                            <option value="Eco Living" {{ old('category') == 'Eco Living' ? 'selected' : '' }}>Eco Living</option>
                                            <option value="Recycling" {{ old('category') == 'Recycling' ? 'selected' : '' }}>Recycling</option>
                                            <option value="Guides" {{ old('category') == 'Guides' ? 'selected' : '' }}>Guides</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Tags <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <input type="text" name="tags" placeholder="e.g. composting, tips, eco-living" value="{{ old('tags') }}"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700">
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">Comma separated tags</p>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Excerpt <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <div class="relative">
                                    <textarea name="excerpt" rows="2" maxlength="200" placeholder="Write a short summary of your article"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 resize-none text-gray-700">{{ old('excerpt') }}</textarea>
                                    <span id="excerpt_counter" class="absolute right-4 bottom-3 text-[9.5px] font-bold text-gray-400">0/200</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 2: Article Content -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Article Content <span class="text-red-500">*</span></h2>
                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
                                <div id="quill-editor" style="min-height: 280px;" class="text-sm text-gray-700"></div>
                                <input type="hidden" name="content" id="content-input" required>
                                <div class="flex justify-end bg-gray-50/40 border-t border-gray-100 px-4 py-1.5 text-[9.5px] text-gray-400 font-semibold select-none">
                                    <span id="content_word_counter">0 words</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 3: Featured Image -->
                        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-4">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Featured Image <span class="text-red-500">*</span></h2>
                            
                            <div id="image-dropzone"
                                class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50 p-6 text-center cursor-pointer hover:border-green-400 hover:bg-green-50/20 transition-all group flex flex-col items-center justify-center min-h-[140px]">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mx-auto mb-2 shadow-sm text-green-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-gray-700">Drag & drop or <span class="text-green-600">click to browse</span></p>
                                <p class="text-[9px] text-gray-400 mt-1">Recommended: 1200×675px (16:9) · JPG, PNG · Max 2MB</p>
                                <input type="file" name="featured_image" id="file-input" accept="image/*" class="hidden">
                            </div>

                            <!-- Selected file information and tiny thumbnail (No stretching!) -->
                            <div id="file-preview-info" class="hidden flex items-center gap-4 p-3 bg-gray-50 border border-gray-150 rounded-xl">
                                <div class="w-16 h-12 rounded-lg overflow-hidden border border-gray-200 shrink-0 bg-white">
                                    <img id="image-preview" class="w-full h-full object-cover" src="" alt="Thumbnail">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p id="preview-filename" class="text-xs font-bold text-gray-700 truncate">No file selected</p>
                                    <p id="preview-filesize" class="text-[10px] text-gray-400 font-bold mt-0.5">0 KB</p>
                                </div>
                                <button type="button" id="btn-remove-image" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer">
                                    Remove
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Right: Publish Panel (1/3) -->
                    <div class="space-y-5">

                        <!-- Blog Preview Widget -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 flex flex-col items-center">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3 w-full mb-4">Blog Post Preview</h2>
                            
                            <!-- Small Card Preview -->
                            <div class="w-full border border-gray-100 rounded-xl overflow-hidden shadow-sm bg-white mb-4">
                                <div class="relative aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                                    <img id="sidebar-preview-image" src="https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                                    <span id="sidebar-preview-category" class="absolute top-3 left-3 bg-[#1A4D2E] text-white text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Category</span>
                                </div>
                                <div class="p-3.5 space-y-2">
                                    <h4 id="sidebar-preview-title" class="font-bold text-gray-800 text-xs line-clamp-2">Your article title will appear here</h4>
                                    <p id="sidebar-preview-excerpt" class="text-[10px] text-gray-400 font-semibold line-clamp-2">A short summary of your article will appear here.</p>
                                </div>
                            </div>
                            
                            <button type="button" onclick="openBlogMockPreview()" class="w-full bg-green-50 hover:bg-green-100 text-green-800 font-bold py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5 border border-green-200/50 cursor-pointer">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>Open Live Mock Preview</span>
                            </button>
                        </div>

                        <!-- Publish Options -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Publish Options</h2>

                            <!-- Status -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Status</label>
                                <div class="relative">
                                    <select name="status" id="status-select" class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 appearance-none font-medium text-gray-700">
                                        <option value="draft" selected>Save as Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <p class="text-[9px] text-gray-400 font-semibold mt-1.5">Draft posts are only visible to you.</p>
                            </div>

                            <!-- Visibility -->
                            <div id="visibility-section" class="hidden">
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Visibility</label>
                                <div class="relative">
                                    <select name="visibility" class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 appearance-none font-medium text-gray-700">
                                        <option value="public" selected>Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Post Toggle -->
                            <div class="flex items-center justify-between py-1">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-700">Featured Post</p>
                                    <p class="text-[9px] text-gray-400 font-semibold mt-0.5">Highlight on blog homepage</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#377A4D]"></div>
                                </label>
                            </div>

                            <div class="h-px bg-gray-100"></div>

                            <button type="submit" class="w-full bg-[#1A4D2E] hover:bg-green-900 text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors">
                                Publish Article
                            </button>
                        </div>

                        <!-- Writing Tips -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3 mb-4">Writing Tips</h2>
                            <ul class="space-y-3">
                                @foreach(['Choose a clear and engaging title', 'Write a short excerpt to summarize your post', 'Use headings to organize your content', 'Add a featured image to increase engagement', 'Keep content informative and practical'] as $tip)
                                <li class="flex items-start gap-2.5 text-[11px] text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $tip }}
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Blog Preview Modal -->
<div id="blog_preview_modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm overflow-y-auto flex items-center justify-center p-4 font-sans">
    <div class="bg-[#F4F7F6] w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Article Preview Mode</span>
            </div>
            <button type="button" onclick="closeBlogMockPreview()" class="text-gray-400 hover:text-gray-700 transition-colors text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Close Preview
            </button>
        </div>
        
        <!-- Modal Body (Scrollable container replicating the real post detail layout) -->
        <div class="flex-1 overflow-y-auto p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Article Content -->
                <div class="lg:col-span-9 bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <article class="prose lg:prose-lg max-w-none text-gray-600">
                        <div class="mb-8">
                            <span id="mock_blog_category" class="text-green-theme text-sm font-semibold bg-green-100 px-3 py-1 rounded-md">Category</span>
                            <h1 id="mock_blog_title" class="mt-4 text-2xl md:text-3xl font-bold text-gray-900 leading-tight">Your article title will appear here</h1>
                            <p id="mock_blog_excerpt" class="lead mt-4 text-base text-gray-500 font-medium leading-relaxed">A short summary of your article will appear here.</p>
                            
                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 mt-6 border-y border-gray-50 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 text-xs">{{ Auth::user()->name ?? 'Admin' }}</span>
                                </div>
                                <span>{{ date('M d, Y') }}</span>
                                <div id="mock_blog_tags" class="flex gap-2 ml-4">
                                    <!-- Dynamic tags -->
                                </div>
                                
                                <div class="ml-auto flex items-center gap-2 text-gray-400 w-full md:w-auto mt-4 md:mt-0">
                                    <span class="text-xs font-semibold mr-1">Share:</span>
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-600 opacity-60"><i class="fab fa-facebook-f text-[10px]"></i></div>
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-400 opacity-60"><i class="fab fa-twitter text-[10px]"></i></div>
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-blue-700 opacity-60"><i class="fab fa-linkedin-in text-[10px]"></i></div>
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-50 border border-gray-100 text-green-600 opacity-60"><i class="fa-solid fa-link text-[10px]"></i></div>
                                </div>
                            </div>
                        </div>
                        
                        <img id="mock_blog_image" src="https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="rounded-xl my-6 w-full object-cover shadow-sm" style="max-height: 400px;">
                        
                        <div id="mock_blog_content" class="prose text-sm text-gray-600 mt-6 leading-relaxed">
                            <!-- Quill content will render here -->
                        </div>
                    </article>
                </div>
                
                <!-- Right: TOC Sidebar -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Table of Contents -->
                    <div id="mock_blog_toc_container" class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-3 text-sm">Table of Contents</h3>
                        <ul id="mock_blog_toc_list" class="text-xs font-semibold p-0 m-0 list-none space-y-2 text-gray-500">
                            <!-- Dynamic TOC items -->
                        </ul>
                    </div>
                    
                    <!-- Dummy sidebar cards for visual fidelity -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm opacity-60">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-leaf text-green-700 text-xs"></i>
                            <h3 class="font-bold text-gray-900 text-sm">Related Articles</h3>
                        </div>
                        <div class="text-[10px] text-gray-400 font-bold">Related articles will be visible after publishing.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Quill ---
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Write your article content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote'],
                ['clean']
            ]
        }
    });

    quill.on('text-change', function() {
        const text = quill.getText().trim();
        const words = text === '' ? 0 : text.split(/\s+/).length;
        document.getElementById('content_word_counter').textContent = `${words} ${words === 1 ? 'word' : 'words'}`;
    });

    document.getElementById('blog-post-form').addEventListener('submit', function(e) {
        if (quill.getText().trim().length === 0 && !quill.root.querySelector('img')) {
            e.preventDefault();
            alert('Please enter some content for your blog post.');
            return;
        }
        document.getElementById('content-input').value = quill.root.innerHTML;
    });

    // --- Counters & Live Sidebar Card Updating ---
    const titleEl = document.getElementById('blog_title');
    const titleCounter = document.getElementById('title_counter');
    const sidebarTitle = document.getElementById('sidebar-preview-title');
    
    titleEl.addEventListener('input', () => {
        titleCounter.textContent = `${titleEl.value.length}/150`;
        sidebarTitle.textContent = titleEl.value.trim() || 'Your article title will appear here';
    });

    const excerptEl = document.querySelector('textarea[name="excerpt"]');
    const excerptCounter = document.getElementById('excerpt_counter');
    const sidebarExcerpt = document.getElementById('sidebar-preview-excerpt');
    
    excerptEl.addEventListener('input', () => {
        excerptCounter.textContent = `${excerptEl.value.length}/200`;
        sidebarExcerpt.textContent = excerptEl.value.trim() || 'A short summary of your article will appear here.';
    });

    const categorySelect = document.querySelector('select[name="category"]');
    const sidebarCategory = document.getElementById('sidebar-preview-category');
    
    categorySelect.addEventListener('change', () => {
        sidebarCategory.textContent = categorySelect.options[categorySelect.selectedIndex].text;
    });

    // --- Status toggle ---
    const statusSelect = document.getElementById('status-select');
    const visibilitySection = document.getElementById('visibility-section');
    function toggleVisibility() {
        visibilitySection.classList.toggle('hidden', statusSelect.value !== 'published');
    }
    statusSelect.addEventListener('change', toggleVisibility);
    toggleVisibility();

    // --- Featured Image ---
    const dropzone = document.getElementById('image-dropzone');
    const fileInput = document.getElementById('file-input');
    const preview = document.getElementById('image-preview');
    const previewInfo = document.getElementById('file-preview-info');
    const previewFilename = document.getElementById('preview-filename');
    const previewFilesize = document.getElementById('preview-filesize');
    const btnRemoveImage = document.getElementById('btn-remove-image');
    const sidebarPreviewImage = document.getElementById('sidebar-preview-image');

    dropzone.addEventListener('click', () => fileInput.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }));
    ['dragenter', 'dragover'].forEach(ev => dropzone.addEventListener(ev, () => dropzone.classList.add('border-green-500', 'bg-green-50/30')));
    ['dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, () => dropzone.classList.remove('border-green-500', 'bg-green-50/30')));

    dropzone.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) { fileInput.files = e.dataTransfer.files; handleFile(e.dataTransfer.files[0]); }
    });
    fileInput.addEventListener('change', function() { if (this.files.length) handleFile(this.files[0]); });

    if (btnRemoveImage) {
        btnRemoveImage.addEventListener('click', () => {
            fileInput.value = '';
            previewInfo.classList.add('hidden');
            previewInfo.classList.remove('flex');
            preview.src = '';
            if (sidebarPreviewImage) {
                sidebarPreviewImage.src = 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
            }
        });
    }

    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            fileInput.value = '';
            return;
        }
        // Check size limit: 2MB (2,097,152 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('The featured image exceeds the 2MB size limit. Please compress the image or choose a smaller one.');
            fileInput.value = '';
            previewInfo.classList.add('hidden');
            previewInfo.classList.remove('flex');
            preview.src = '';
            if (sidebarPreviewImage) {
                sidebarPreviewImage.src = 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
            }
            return;
        }

        previewFilename.textContent = file.name;
        previewFilesize.textContent = (file.size / 1024).toFixed(1) + ' KB';

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewInfo.classList.remove('hidden');
            previewInfo.classList.add('flex');
            if (sidebarPreviewImage) {
                sidebarPreviewImage.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }

    // --- Mock Preview Functions ---
    window.openBlogMockPreview = function() {
        const titleVal = titleEl.value.trim() || 'Untitled Article';
        const categoryVal = categorySelect.selectedIndex > 0 ? categorySelect.options[categorySelect.selectedIndex].text : 'Uncategorized';
        const excerptVal = excerptEl.value.trim() || 'Article excerpt...';
        const tagsVal = document.querySelector('input[name="tags"]')?.value || '';
        const contentVal = quill.root.innerHTML;

        document.getElementById('mock_blog_title').textContent = titleVal;
        document.getElementById('mock_blog_category').textContent = categoryVal;
        document.getElementById('mock_blog_excerpt').textContent = excerptVal;
        document.getElementById('mock_blog_content').innerHTML = contentVal;

        const tagsContainer = document.getElementById('mock_blog_tags');
        tagsContainer.innerHTML = '';
        if (tagsVal) {
            tagsVal.split(',').map(t => t.trim()).forEach(tag => {
                if (tag) {
                    const span = document.createElement('span');
                    span.className = 'bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-bold';
                    span.textContent = tag;
                    tagsContainer.appendChild(span);
                }
            });
        }

        const mockImg = document.getElementById('mock_blog_image');
        if (preview && preview.src && previewInfo && !previewInfo.classList.contains('hidden')) {
            mockImg.src = preview.src;
        } else {
            mockImg.src = 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
        }

        // Dynamic TOC for Preview
        const mockTOCContainer = document.getElementById('mock_blog_toc_container');
        const mockTOCList = document.getElementById('mock_blog_toc_list');
        mockTOCList.innerHTML = '';
        
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = contentVal;
        const headings = tempDiv.querySelectorAll('h1, h2');
        
        if (headings.length === 0) {
            mockTOCContainer.classList.add('hidden');
        } else {
            mockTOCContainer.classList.remove('hidden');
            headings.forEach((heading, index) => {
                const li = document.createElement('li');
                const isH2 = heading.tagName.toLowerCase() === 'h2';
                li.innerHTML = `
                    <div class="flex items-center gap-2 ${isH2 ? 'pl-6' : 'p-1.5'} rounded-lg text-gray-500 hover:text-green-800">
                        <div class="rounded-full ${isH2 ? 'w-1 h-1 bg-gray-300' : 'w-1.5 h-1.5 bg-gray-400'} shrink-0"></div>
                        <span class="truncate ${isH2 ? 'text-xs font-semibold' : ''}">${heading.textContent.trim()}</span>
                    </div>
                `;
                mockTOCList.appendChild(li);
            });
        }

        document.getElementById('blog_preview_modal').classList.remove('hidden');
    };

    window.closeBlogMockPreview = function() {
        document.getElementById('blog_preview_modal').classList.add('hidden');
    };
});
</script>
@endsection
