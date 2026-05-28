<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard displays correct dynamic impact overview metrics', function () {
    $customer = User::factory()->create(['role' => 'user']);
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true]);
    
    // Create Recyclables service
    $serviceRecycle = Service::create([
        'user_id' => $provider->id,
        'name' => 'Recycling Pick',
        'category' => 'Recyclables',
        'description' => 'Recycle plastic',
        'price' => 50,
        'status' => 'active',
    ]);
    
    // Create E-Waste service
    $serviceEWaste = Service::create([
        'user_id' => $provider->id,
        'name' => 'E-waste Pick',
        'category' => 'E-Waste',
        'description' => 'Recycle battery',
        'price' => 80,
        'status' => 'active',
    ]);

    // Create completed booking for recyclables
    Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $serviceRecycle->id,
        'scheduled_at' => now()->subDays(5)->format('Y-m-d H:i:s'),
        'price' => 50,
        'status' => 'completed',
        'waste_amount' => 20.0,
    ]);

    // Create completed booking for e-waste
    Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $serviceEWaste->id,
        'scheduled_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        'price' => 80,
        'status' => 'completed',
        'waste_amount' => 15.0,
    ]);

    // Total expected waste saved: 20.0 + 15.0 = 35.0 kg
    // Expected CO2 offset: 35.0 * 0.5 = 17.5 kg
    // Expected trees equivalent: 17.5 * 0.075 = 1.3125 (formatted to 1.3)

    $response = $this->actingAs($customer)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('wasteSaved', 35.0);
    $response->assertViewHas('co2Offset', 17.5);
    $response->assertViewHas('treesEquivalent', 1.3125);
});

test('provider can complete booking with actual waste amount', function () {
    $customer = User::factory()->create(['role' => 'user']);
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => true,
        'profile_completed' => true,
    ]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Composting Service',
        'category' => 'Composting',
        'description' => 'Compost waste',
        'price' => 100,
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'scheduled_at' => now()->format('Y-m-d H:i:s'),
        'price' => 100,
        'status' => 'confirmed',
    ]);

    $response = $this->actingAs($provider)
        ->put(route('bookings.update', $booking), [
            'status' => 'completed',
            'waste_amount' => 18.5,
        ]);

    $response->assertRedirect(route('bookings.index'));
    $booking->refresh();

    $this->assertEquals('completed', $booking->status);
    $this->assertEquals(18.5, $booking->waste_amount);
});
