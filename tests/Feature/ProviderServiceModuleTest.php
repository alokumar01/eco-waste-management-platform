<?php

use App\Models\CompostingService;
use App\Models\User;

test('provider can manage profile and submit a composting service for review', function () {
    $provider = User::factory()->provider([
        'provider_status' => User::PROVIDER_PENDING,
        'approved_at' => null,
    ])->create();

    $this->actingAs($provider)
        ->get(route('provider.dashboard'))
        ->assertOk()
        ->assertSee('Provider profile');

    $this->actingAs($provider)
        ->patch(route('provider.profile.update'), [
            'business_name' => 'Leaf Loop Composting',
            'phone' => '+91 9876543210',
            'service_area' => 'Bengaluru East',
            'address' => '12 Green Street',
            'bio' => 'Neighborhood-scale organic waste pickup and composting.',
        ])
        ->assertRedirect();

    $response = $this->actingAs($provider)
        ->post(route('provider.services.store'), [
            'title' => 'Weekly food scrap pickup',
            'category' => CompostingService::CATEGORY_COMPOSTING_PICKUP,
            'description' => 'We collect segregated kitchen scraps weekly and process them into nutrient-rich compost for local gardens.',
            'location' => 'Indiranagar, Bengaluru',
            'service_radius_km' => 12,
            'price' => 799,
            'unit' => 'month',
            'capacity_kg_per_week' => 500,
            'availability' => 'Pickup every Tuesday and Friday.',
            'submit_for_review' => true,
        ]);

    $response->assertRedirect(route('provider.services.index'));

    $this->assertDatabaseHas('composting_services', [
        'provider_id' => $provider->id,
        'title' => 'Weekly food scrap pickup',
        'approval_status' => CompostingService::STATUS_PENDING,
        'is_published' => false,
    ]);
});

test('approved providers can publish approved services to the public catalog', function () {
    $provider = User::factory()->provider()->create();
    $admin = User::factory()->admin()->create();
    $service = CompostingService::factory()
        ->for($provider, 'provider')
        ->pendingReview()
        ->create([
            'title' => 'Apartment composting pickup',
        ]);

    $this->actingAs($provider)
        ->patch(route('provider.services.publish', $service))
        ->assertSessionHasErrors('publish');

    $this->actingAs($admin)
        ->patch(route('admin.services.approve', $service))
        ->assertRedirect();

    $this->actingAs($provider)
        ->patch(route('provider.services.publish', $service))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->get(route('services.index'))
        ->assertOk()
        ->assertSee('Apartment composting pickup');
});
