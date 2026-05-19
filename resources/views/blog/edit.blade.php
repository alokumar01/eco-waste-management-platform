@extends('layouts.app')
@section('no_container', true)
@section('no_top_nav', true)

@section('content')
<div class="flex h-screen bg-[#F4F7F6] font-sans overflow-hidden">
    @include('provider-dashboard-sidebar')

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        @include('provider-dashboard-header')

        <div class="flex-1 overflow-y-auto bg-[#F4F7F6] p-6 md:p-10 pb-20">

            <!-- Page Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">Edit Blog Post</h1>
                    <p class="text-sm text-gray-400 font-medium mt-1">Update your article content and settings.</p>
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

            <form id="blog-post-form" action="{{ url('provider/blog/' . $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                    <input type="text" name="title" required placeholder="Enter an engaging title" maxlength="150"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700"
                                        value="{{ old('title', $post->title) }}" id="blog_title">
                                    <span id="title_counter" class="absolute right-4 top-1/2 -translate-y-1/2 text-[9.5px] font-bold text-gray-400">{{ strlen(old('title', $post->title)) }}/150</span>
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
                                            <option value="" disabled>Select category</option>
                                            @foreach(['Composting','Waste Management','Sustainability','Eco Living','Recycling','Guides'] as $cat)
                                                <option value="{{ $cat }}" {{ old('category', $post->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Tags <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <input type="text" name="tags" placeholder="e.g. composting, tips, eco-living"
                                        value="{{ old('tags', is_array($post->tags) ? implode(', ', $post->tags) : '') }}"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 text-gray-700">
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">Comma separated tags</p>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Excerpt <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <div class="relative">
                                    <textarea name="excerpt" rows="2" maxlength="200" placeholder="Write a short summary of your article"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 resize-none text-gray-700">{{ old('excerpt', $post->excerpt) }}</textarea>
                                    <span id="excerpt_counter" class="absolute right-4 bottom-3 text-[9.5px] font-bold text-gray-400">{{ strlen(old('excerpt', $post->excerpt)) }}/200</span>
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
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Featured Image</h2>
                            <div id="image-dropzone"
                                class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50 p-8 text-center cursor-pointer hover:border-green-400 hover:bg-green-50/20 transition-all relative overflow-hidden group min-h-[180px] flex items-center justify-center">
                                <div id="dropzone-content" class="transition-opacity duration-300 z-10 relative {{ $post->featured_image ? 'opacity-0 pointer-events-none' : '' }}">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm text-green-600 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-xs font-bold text-gray-700">Drag & drop or <span class="text-green-600">click to browse</span></p>
                                    <p class="text-[10px] text-gray-400 mt-1">Leave empty to keep current image</p>
                                </div>
                                <img id="image-preview" class="{{ $post->featured_image ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-0"
                                    src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}" alt="Preview">
                                <div id="change-image-overlay" class="{{ $post->featured_image ? 'flex' : 'hidden' }} absolute inset-0 bg-black/40 items-center justify-center text-white font-medium opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                    <div class="flex items-center gap-2 bg-white/20 px-4 py-2 rounded-lg border border-white/30 text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Change Image
                                    </div>
                                </div>
                                <input type="file" name="featured_image" id="file-input" accept="image/*" class="hidden">
                            </div>
                        </div>

                    </div>

                    <!-- Right: Publish Panel (1/3) -->
                    <div class="space-y-5">

                        <!-- Publish Options -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100 space-y-5">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3">Update Options</h2>

                            <!-- Status -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Status</label>
                                <div class="relative">
                                    <select name="status" id="status-select" class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 appearance-none font-medium text-gray-700">
                                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Visibility -->
                            <div id="visibility-section" class="hidden">
                                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Visibility</label>
                                <div class="relative">
                                    <select name="visibility" class="w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-all bg-gray-50/20 appearance-none font-medium text-gray-700">
                                        <option value="public" {{ old('visibility', $post->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                        <option value="private" {{ old('visibility', $post->visibility) == 'private' ? 'selected' : '' }}>Private</option>
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
                                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#377A4D]"></div>
                                </label>
                            </div>

                            <div class="h-px bg-gray-100"></div>

                            <button type="submit" class="w-full bg-[#1A4D2E] hover:bg-green-900 text-white font-bold text-sm px-4 py-2 rounded-lg transition-colors">
                                Save Changes
                            </button>
                        </div>

                        <!-- Post Info -->
                        <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.015)] border border-gray-100">
                            <h2 class="text-[13px] font-bold text-gray-800 tracking-wide border-b border-gray-50 pb-3 mb-4">Post Info</h2>
                            <div class="space-y-3 text-[11px] text-gray-600">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-400 uppercase text-[9px] tracking-wide">Created</span>
                                    <span class="font-bold text-gray-700">{{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-400 uppercase text-[9px] tracking-wide">Last Updated</span>
                                    <span class="font-bold text-gray-700">{{ $post->updated_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-400 uppercase text-[9px] tracking-wide">Current Status</span>
                                    <span class="font-bold {{ $post->status === 'published' ? 'text-green-600' : 'text-amber-500' }} capitalize">{{ $post->status }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
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

    const existingContent = {!! json_encode(old('content', $post->content)) !!};
    if (existingContent) quill.root.innerHTML = existingContent;

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

    // --- Counters ---
    const titleEl = document.getElementById('blog_title');
    const titleCounter = document.getElementById('title_counter');
    titleEl.addEventListener('input', () => titleCounter.textContent = `${titleEl.value.length}/150`);

    const excerptEl = document.querySelector('textarea[name="excerpt"]');
    const excerptCounter = document.getElementById('excerpt_counter');
    excerptEl.addEventListener('input', () => excerptCounter.textContent = `${excerptEl.value.length}/200`);

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
    const dropzoneContent = document.getElementById('dropzone-content');
    const changeOverlay = document.getElementById('change-image-overlay');

    dropzone.addEventListener('click', () => fileInput.click());
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }));
    ['dragenter', 'dragover'].forEach(ev => dropzone.addEventListener(ev, () => dropzone.classList.add('border-green-500', 'bg-green-50/30')));
    ['dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, () => dropzone.classList.remove('border-green-500', 'bg-green-50/30')));

    dropzone.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) { fileInput.files = e.dataTransfer.files; handleFile(e.dataTransfer.files[0]); }
    });
    fileInput.addEventListener('change', function() { if (this.files.length) handleFile(this.files[0]); });

    function handleFile(file) {
        if (!file.type.startsWith('image/')) { alert('Please select a valid image file.'); return; }
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            changeOverlay.classList.remove('hidden');
            changeOverlay.classList.add('flex');
            dropzoneContent.classList.add('opacity-0', 'pointer-events-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
