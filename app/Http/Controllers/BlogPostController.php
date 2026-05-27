<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('blog.index-provider', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string',
            'tags' => 'nullable|string',
            'excerpt' => 'nullable|string|max:200',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'visibility' => 'required|in:public,private',
            'is_featured' => 'nullable|boolean',
        ]);

        $tagsArray = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        $slug = Str::slug($validated['title']) . '-' . uniqid();

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        BlogPost::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'tags' => $tagsArray,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'status' => $validated['status'],
            'visibility' => $validated['visibility'],
            'is_featured' => $request->has('is_featured'),
            'user_id' => Auth::id(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.blog.all-articles')->with('success', 'Blog post created successfully.');
        }
        return redirect()->route('blog.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Ensure user owns this post or is admin
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Ensure user owns this post or is admin
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string',
            'tags' => 'nullable|string',
            'excerpt' => 'nullable|string|max:200',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'visibility' => 'required|in:public,private',
            'is_featured' => 'nullable|boolean',
        ]);

        $tagsArray = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        
        // Only generate new slug if title changed
        if ($validated['title'] !== $post->title) {
            $post->slug = Str::slug($validated['title']) . '-' . uniqid();
        }

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            // Store new image
            $post->featured_image = $request->file('featured_image')->store('blog', 'public');
        }

        $post->title = $validated['title'];
        $post->category = $validated['category'];
        $post->tags = $tagsArray;
        $post->excerpt = $validated['excerpt'];
        $post->content = $validated['content'];
        $post->status = $validated['status'];
        $post->visibility = $validated['visibility'];
        $post->is_featured = $request->has('is_featured');
        $post->published_at = $validated['status'] === 'published' && !$post->published_at ? now() : $post->published_at;

        $post->save();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.blog.all-articles')->with('success', 'Blog post updated successfully.');
        }
        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Ensure user owns this post or is admin
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.blog.all-articles')->with('success', 'Blog post deleted successfully.');
        }
        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Preview the specified resource.
     */
    public function preview(string $id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Ensure user owns this post or is admin
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get popular articles for the sidebar
        $popularPosts = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $isPreview = true;

        return view('blog.show', compact('post', 'popularPosts', 'isPreview'));
    }
}
