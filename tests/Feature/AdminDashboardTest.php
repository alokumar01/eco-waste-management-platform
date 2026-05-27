<?php

use App\Models\User;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can access providers list and verify a provider', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => false,
        'business_name' => 'Eco Recycling Co'
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.providers'));

    $response->assertOk();
    $response->assertSee('Eco Recycling Co');
    $response->assertSee('Pending Verification');

    // Verify provider
    $response = $this
        ->actingAs($admin)
        ->from(route('admin.providers'))
        ->post(route('admin.verifyProvider', $provider));

    $response->assertRedirect(route('admin.providers'));
    $provider->refresh();
    expect($provider->is_verified)->toBeTrue();
});

test('admin can access reviews page and delete a review', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Composting Service',
        'category' => 'Composting',
        'description' => 'Test compost',
        'price' => 100,
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'status' => 'completed',
        'price' => 100,
        'scheduled_at' => now()->format('Y-m-d H:i:s'),
    ]);

    $review = Review::create([
        'booking_id' => $booking->id,
        'user_id' => $customer->id,
        'provider_id' => $provider->id,
        'rating' => 5,
        'comment' => 'Exceptional service provided!'
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.reviews'));

    $response->assertOk();
    $response->assertSee('Exceptional service provided!');

    // Delete review
    $response = $this
        ->actingAs($admin)
        ->from(route('admin.reviews'))
        ->delete(route('admin.reviews.destroy', $review));

    $response->assertRedirect(route('admin.reviews'));
    expect(Review::find($review->id))->toBeNull();
});

test('admin can view all articles and toggle status', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    $post = BlogPost::create([
        'title' => 'Important Sustainability Tips',
        'slug' => 'important-sustainability-tips',
        'category' => 'Sustainability',
        'content' => 'Content of post.',
        'status' => 'draft',
        'visibility' => 'public',
        'user_id' => $provider->id,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.blog.all-articles'));

    $response->assertOk();
    $response->assertSee('Important Sustainability Tips');

    // Toggle status to published
    $response = $this
        ->actingAs($admin)
        ->from(route('admin.blog.all-articles'))
        ->post(route('admin.blog.toggle-status', $post));

    $response->assertRedirect(route('admin.blog.all-articles'));
    $post->refresh();
    expect($post->status)->toBe('published');
    expect($post->published_at)->not->toBeNull();
});

test('admin can access and edit profile', function () {
    \Illuminate\Support\Facades\Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.profile.edit'));

    $response->assertOk();
    $response->assertSee('Admin Profile Settings');

    // Update profile details
    $response = $this
        ->actingAs($admin)
        ->from(route('admin.profile.edit'))
        ->put(route('admin.profile.update'), [
            'name' => 'Updated Admin Name',
            'email' => 'newadmin@greenloop.com',
            'password' => 'SecretPassword123!',
            'password_confirmation' => 'SecretPassword123!',
            'profile_picture' => \Illuminate\Http\UploadedFile::fake()->image('avatar.png'),
        ]);

    $response->assertRedirect(route('admin.profile.edit'));
    
    $admin->refresh();
    expect($admin->name)->toBe('Updated Admin Name');
    expect($admin->email)->toBe('newadmin@greenloop.com');
    expect(\Illuminate\Support\Facades\Hash::check('SecretPassword123!', $admin->password))->toBeTrue();
    expect($admin->profile_picture)->not->toBeNull();
    \Illuminate\Support\Facades\Storage::disk('public')->assertExists($admin->profile_picture);
});

test('admin can view and delete a service', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Organic Scrap Collection',
        'category' => 'Organic Waste',
        'description' => 'Weekly organic food waste collection.',
        'price' => 250,
        'unit' => 'kg',
        'status' => 'active',
    ]);

    // View service details
    $response = $this
        ->actingAs($admin)
        ->get(route('services.show', $service));

    $response->assertOk();
    $response->assertSee('Organic Scrap Collection');
    $response->assertSee('Delete Service');

    // Delete service
    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.services.destroy', $service));

    $response->assertRedirect(route('services.list'));
    expect(Service::find($service->id))->toBeNull();

    // Verify notification was sent to provider in the database
    $this->assertDatabaseHas('notifications', [
        'user_id' => $provider->id,
        'type' => 'service_deleted_violation',
        'title' => 'Service Removed: Violation Notice',
        'message' => "Your service 'Organic Scrap Collection' has been removed due to a policy violation."
    ]);
});

test('navigation bar links adapt based on user role', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'user', 'status' => 'active']);

    // Admin view public services page
    $response = $this->actingAs($admin)->get(route('services.list'));
    $response->assertSee(route('admin.dashboard'));
    $response->assertSee(route('admin.profile.edit'));
    $response->assertDontSee(route('profile.edit'));

    // Provider view public services page
    $response = $this->actingAs($provider)->get(route('services.list'));
    $response->assertSee(route('provider.dashboard'));
    $response->assertSee(route('provider.profile.edit'));
    $response->assertDontSee(route('profile.edit'));

    // Customer view public services page
    $response = $this->actingAs($customer)->get(route('services.list'));
    $response->assertSee(route('dashboard'));
    $response->assertSee(route('profile.edit'));
    $response->assertDontSee(route('admin.dashboard'));
    $response->assertDontSee(route('provider.dashboard'));
});

test('admin can access all bookings list page', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'user', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Composting Service',
        'category' => 'Composting',
        'description' => 'Test compost',
        'price' => 100,
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'status' => 'completed',
        'price' => 100,
        'scheduled_at' => now()->format('Y-m-d H:i:s'),
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.bookings'));

    $response->assertOk();
    $response->assertSee('GL-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT));
});

test('admin can access all transactions list page', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'user', 'status' => 'active']);
    $provider = User::factory()->create(['role' => 'provider', 'status' => 'active']);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Composting Service',
        'category' => 'Composting',
        'description' => 'Test compost',
        'price' => 100,
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'status' => 'completed',
        'price' => 100,
        'scheduled_at' => now()->format('Y-m-d H:i:s'),
    ]);

    $transaction = \App\Models\Transaction::create([
        'booking_id' => $booking->id,
        'payment_gateway_ref' => 'pay_test123456',
        'amount' => 100,
        'status' => 'completed',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.transactions'));

    $response->assertOk();
    $response->assertSee('PAY_TEST');
});
