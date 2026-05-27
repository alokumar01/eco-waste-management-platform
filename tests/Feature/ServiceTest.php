<?php

use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('verified provider can load service creation page and store service', function () {
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => true,
        'profile_completed' => true,
    ]);

    $response = $this->actingAs($provider)->get(route('services.create'));
    $response->assertStatus(200);

    $response = $this->actingAs($provider)->post(route('services.store'), [
        'name' => 'Organic Composting Service',
        'category' => 'Composting',
        'description' => 'Collect and compost organic kitchen waste.',
        'detailed_description' => 'Detailed description here.',
        'type' => 'Pickup Service',
        'price' => 250,
        'unit' => 'kg',
        'duration' => 'Weekly',
        'what_we_accept' => 'Fruit scraps, coffee grounds',
        'what_we_dont_accept' => 'Plastics, meats',
        'city' => 'Bengaluru',
    ]);

    $response->assertRedirect(route('services.index'));
    $this->assertDatabaseHas('services', [
        'name' => 'Organic Composting Service',
        'user_id' => $provider->id,
        'price' => 250,
    ]);
});

test('unverified provider is redirected to dashboard when accessing service creation page', function () {
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => false,
        'profile_completed' => true,
    ]);

    $response = $this->actingAs($provider)->get(route('services.create'));
    $response->assertRedirect(route('provider.dashboard'));
});

test('customer cannot access service creation page', function () {
    $customer = User::factory()->create([
        'role' => 'user',
        'is_verified' => true,
    ]);

    $response = $this->actingAs($customer)->get(route('services.create'));
    $response->assertStatus(403);
});
