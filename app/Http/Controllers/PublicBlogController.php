<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class PublicBlogController extends Controller
{
    public function index()
    {
        // Get the featured post (most recent one marked as featured)
        $featuredPost = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        // If no featured post, just grab the most recent one
        if (!$featuredPost) {
            $featuredPost = BlogPost::where('status', 'published')
                ->where('visibility', 'public')
                ->latest('published_at')
                ->first();
        }

        // Get latest articles excluding the featured one
        $postsQuery = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->latest('published_at');
            
        if ($featuredPost) {
            $postsQuery->where('id', '!=', $featuredPost->id);
        }
        
        $posts = $postsQuery->paginate(8);

        // Get popular articles (for now, just randomly picking 4 published ones for demonstration)
        $popularPosts = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('blog', compact('featuredPost', 'posts', 'popularPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->firstOrFail();

        // Get popular articles for the sidebar
        $popularPosts = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('blog.show', compact('post', 'popularPosts'));
    }
}
