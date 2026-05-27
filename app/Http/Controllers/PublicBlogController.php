<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        // Get the featured post (most recent one marked as featured, matching category/search if selected)
        $featuredPostQuery = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->where('is_featured', true);

        if ($category) {
            $featuredPostQuery->where('category', $category);
        }

        if ($search) {
            $featuredPostQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $featuredPost = $featuredPostQuery->latest('published_at')->first();

        // If no featured post, just grab the most recent one (matching category/search if selected)
        if (!$featuredPost) {
            $fallbackQuery = BlogPost::where('status', 'published')
                ->where('visibility', 'public');

            if ($category) {
                $fallbackQuery->where('category', $category);
            }

            if ($search) {
                $fallbackQuery->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            $featuredPost = $fallbackQuery->latest('published_at')->first();
        }

        // Get latest articles excluding the featured one (matching category/search if selected)
        $postsQuery = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->latest('published_at');

        if ($category) {
            $postsQuery->where('category', $category);
        }

        if ($search) {
            $postsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
            
        if ($featuredPost) {
            $postsQuery->where('id', '!=', $featuredPost->id);
        }
        
        $posts = $postsQuery->paginate(8);

        if ($category) {
            $posts->appends(['category' => $category]);
        }
        if ($search) {
            $posts->appends(['search' => $search]);
        }

        // Get popular articles
        $popularPosts = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Calculate dynamic category counts
        $categoryCounts = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $totalArticlesCount = BlogPost::where('status', 'published')
            ->where('visibility', 'public')
            ->count();

        $allParams = [];
        if ($search) {
            $allParams['search'] = $search;
        }

        $categoriesList = [
            [
                'name' => 'All Articles',
                'count' => $totalArticlesCount,
                'icon' => 'fa-solid fa-border-all',
                'active' => empty($category),
                'url' => route('public.blog.index', $allParams)
            ]
        ];

        $availableCategories = [
            'Composting' => 'fa-solid fa-leaf',
            'Waste Management' => 'fa-solid fa-trash-can',
            'Sustainability' => 'fa-solid fa-recycle',
            'Eco Living' => 'fa-solid fa-house',
            'Recycling' => 'fa-solid fa-boxes-packing',
            'Guides' => 'fa-solid fa-book',
        ];

        foreach ($availableCategories as $catName => $icon) {
            $catParams = ['category' => $catName];
            if ($search) {
                $catParams['search'] = $search;
            }
            $categoriesList[] = [
                'name' => $catName,
                'count' => $categoryCounts[$catName] ?? 0,
                'icon' => $icon,
                'active' => $category === $catName,
                'url' => route('public.blog.index', $catParams)
            ];
        }

        return view('blog', compact('featuredPost', 'posts', 'popularPosts', 'categoriesList'));
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
