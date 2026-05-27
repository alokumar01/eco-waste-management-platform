<?php

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('provider can create blog post with featured image', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'provider', 'status' => 'active']);

    $response = $this
        ->actingAs($user)
        ->post('provider/blog', [
            'title' => 'My Sustainable Article',
            'category' => 'Sustainability',
            'tags' => 'tips, eco',
            'excerpt' => 'A short summary.',
            'content' => '<p>This is the content of the article.</p>',
            'featured_image' => UploadedFile::fake()->image('featured.jpg'),
            'status' => 'published',
            'visibility' => 'public',
        ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('blog.index'));

    $post = BlogPost::first();
    expect($post)->not->toBeNull();
    expect($post->title)->toBe('My Sustainable Article');
    expect($post->featured_image)->not->toBeNull();

    Storage::disk('public')->assertExists($post->featured_image);
});

test('provider can preview their blog post (draft or published)', function () {
    $user = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    $post = BlogPost::create([
        'title' => 'Draft Article Preview',
        'slug' => 'draft-article-preview',
        'category' => 'Composting',
        'content' => 'Preview content here.',
        'status' => 'draft',
        'visibility' => 'public',
        'user_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get("provider/blog/{$post->id}/preview");

    $response->assertOk();
    $response->assertViewHas('post', $post);
    $response->assertSee('Preview Mode: This is a preview of your blog article');
});

test('visitor can filter blog posts by category', function () {
    $user = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    // Create Composting post
    BlogPost::create([
        'title' => 'Composting Guide',
        'slug' => 'composting-guide',
        'category' => 'Composting',
        'content' => 'Composting content.',
        'status' => 'published',
        'visibility' => 'public',
        'user_id' => $user->id,
        'published_at' => now(),
    ]);

    // Create Recycling post
    BlogPost::create([
        'title' => 'Recycling Tips',
        'slug' => 'recycling-tips',
        'category' => 'Recycling',
        'content' => 'Recycling content.',
        'status' => 'published',
        'visibility' => 'public',
        'user_id' => $user->id,
        'published_at' => now(),
    ]);

    // Request Composting category
    $response = $this->get('/blog?category=Composting');
    $response->assertOk();
    $response->assertViewHas('featuredPost', function ($post) {
        return $post && $post->title === 'Composting Guide';
    });
    $response->assertViewHas('posts', function ($posts) {
        return !$posts->contains('title', 'Recycling Tips');
    });

    // Request Recycling category
    $response = $this->get('/blog?category=Recycling');
    $response->assertOk();
    $response->assertViewHas('featuredPost', function ($post) {
        return $post && $post->title === 'Recycling Tips';
    });
    $response->assertViewHas('posts', function ($posts) {
        return !$posts->contains('title', 'Composting Guide');
    });
});

test('visitor can search blog posts by keyword', function () {
    $user = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    // Create Composting post
    BlogPost::create([
        'title' => 'Composting Guide for Beginners',
        'slug' => 'composting-guide',
        'category' => 'Composting',
        'content' => 'Composting content with useful tips.',
        'status' => 'published',
        'visibility' => 'public',
        'user_id' => $user->id,
        'published_at' => now(),
    ]);

    // Create Recycling post
    BlogPost::create([
        'title' => 'Advanced Recycling Tips',
        'slug' => 'recycling-tips',
        'category' => 'Recycling',
        'content' => 'Recycling content with modern plastic rules.',
        'status' => 'published',
        'visibility' => 'public',
        'user_id' => $user->id,
        'published_at' => now(),
    ]);

    // Search for "Beginners"
    $response = $this->get('/blog?search=Beginners');
    $response->assertOk();
    $response->assertViewHas('featuredPost', function ($post) {
        return $post && $post->title === 'Composting Guide for Beginners';
    });
    $response->assertViewHas('posts', function ($posts) {
        return !$posts->contains('title', 'Advanced Recycling Tips');
    });

    // Search for "plastic"
    $response = $this->get('/blog?search=plastic');
    $response->assertOk();
    $response->assertViewHas('featuredPost', function ($post) {
        return $post && $post->title === 'Advanced Recycling Tips';
    });
    $response->assertViewHas('posts', function ($posts) {
        return !$posts->contains('title', 'Composting Guide for Beginners');
    });
});
