<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('provider dashboard displays complete now when profile is not 100% complete', function () {
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => false,
        'profile_completed' => true,
        'name' => 'Provider Name',
        'email' => 'provider@example.com',
        'phone_number' => '', // Incomplete basic info -> less than 100%
    ]);

    $response = $this->actingAs($provider)->get(route('provider.dashboard'));

    $response->assertOk();
    $response->assertSee('Complete Your Profile');
    $response->assertSee('Complete Now');
    $response->assertDontSee('Profile Completed');
    $response->assertDontSee('Edit Profile');
});

test('provider dashboard displays profile completed and edit profile when profile is 100% complete', function () {
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => true, // Bank details step complete
        'profile_completed' => true,
        'name' => 'Provider Name',
        'email' => 'provider@example.com',
        'phone_number' => '1234567890', // Basic info step complete
        'profile_picture' => 'avatar.png', // Profile pic step complete
        'business_name' => 'Eco Biz',
        'bio' => 'Eco bio text', // Business details step complete
        'business_address' => '123 street',
        'city' => 'Bengaluru',
        'state' => 'Karnataka',
        'pincode' => '560001', // Service location step complete
    ]);

    $response = $this->actingAs($provider)->get(route('provider.dashboard'));

    $response->assertOk();
    $response->assertSee('Profile Completed');
    $response->assertSee('Edit Profile');
    $response->assertDontSee('Complete Now');
});
