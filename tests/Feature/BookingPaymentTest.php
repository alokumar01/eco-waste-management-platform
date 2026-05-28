<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated user is redirected to login when accessing payment page', function () {
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true]);
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Test Service',
        'category' => 'Composting',
        'description' => 'Test description',
        'type' => 'pickup',
        'price' => 200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'organic',
        'what_we_dont_accept' => 'plastic',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $response = $this->get(route('bookings.payment', [
        'service_id' => $service->id,
        'scheduled_at' => '2026-06-01 09:00:00',
    ]));

    $response->assertRedirect(route('login'));
});

test('authenticated customer can load the payment page with service details', function () {
    $customer = User::factory()->create(['role' => 'user', 'is_verified' => true]);
    $provider = User::factory()->create([
        'role' => 'provider',
        'is_verified' => true,
        'business_name' => 'EcoClean Services',
        'city' => 'Bengaluru',
        'state' => 'Karnataka',
    ]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Dry Waste Pickup Service',
        'category' => 'Recycling',
        'description' => 'Pickup dry waste',
        'type' => 'pickup',
        'price' => 1200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'paper, plastic',
        'what_we_dont_accept' => 'food waste',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $response = $this->actingAs($customer)->get(route('bookings.payment', [
        'service_id' => $service->id,
        'scheduled_at' => '2026-06-01 09:00:00',
        'instructions' => 'Call before coming',
    ]));

    $response->assertStatus(200);
    $response->assertSee('Complete Your Payment');
    $response->assertSee('Dry Waste Pickup Service');
    $response->assertSee('EcoClean Services');
    $response->assertSee('Platform Fee');
    $response->assertSee('₹1,350.00'); // 1200 + 150
});

test('customer can submit the payment form to create a booking successfully', function () {
    $customer = User::factory()->create(['role' => 'user', 'is_verified' => true]);
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Dry Waste Pickup Service',
        'category' => 'Recycling',
        'description' => 'Pickup dry waste',
        'type' => 'pickup',
        'price' => 1200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'paper',
        'what_we_dont_accept' => 'food',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $scheduledAt = '2026-06-01 09:00:00';

    $response = $this->actingAs($customer)->post(route('bookings.store'), [
        'service_id' => $service->id,
        'scheduled_at' => $scheduledAt,
        'instructions' => 'Leave near gate',
        'upi_vpa' => 'success@upi',
    ]);

    $response->assertRedirect(route('bookings.my'));
    $this->assertDatabaseHas('bookings', [
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'scheduled_at' => $scheduledAt,
        'price' => 1200,
        'status' => 'pending',
    ]);
});

test('provider can accept booking and it changes status to accepted', function () {
    $customer = User::factory()->create(['role' => 'user', 'is_verified' => true]);
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true, 'profile_completed' => true]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Dry Waste Pickup Service',
        'category' => 'Recycling',
        'description' => 'Pickup dry waste',
        'type' => 'pickup',
        'price' => 1200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'paper',
        'what_we_dont_accept' => 'food',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'scheduled_at' => '2026-06-01 09:00:00',
        'price' => 1200,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($provider)->put(route('bookings.update', $booking->id), [
        'status' => 'accepted',
    ]);

    $response->assertRedirect(route('bookings.index'));
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'accepted',
        'payment_status' => 'unpaid',
    ]);
});

test('customer can pay for accepted booking and confirm it', function () {
    $customer = User::factory()->create(['role' => 'user', 'is_verified' => true]);
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true, 'profile_completed' => true]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Dry Waste Pickup Service',
        'category' => 'Recycling',
        'description' => 'Pickup dry waste',
        'type' => 'pickup',
        'price' => 1200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'paper',
        'what_we_dont_accept' => 'food',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'scheduled_at' => '2026-06-01 09:00:00',
        'price' => 1200,
        'status' => 'accepted',
        'payment_status' => 'unpaid',
    ]);

    $response = $this->actingAs($customer)->post(route('bookings.pay', $booking->id), [
        'upi_vpa' => 'success@upi',
    ]);

    $response->assertRedirect(route('bookings.my'));
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'confirmed',
        'payment_status' => 'paid',
    ]);

    $this->assertDatabaseHas('transactions', [
        'booking_id' => $booking->id,
        'amount' => 1200,
        'status' => 'completed',
    ]);
});

test('booking cancellation refunds paid amount and notifies customer', function () {
    \Illuminate\Support\Facades\Notification::fake();

    $customer = User::factory()->create(['role' => 'user', 'is_verified' => true]);
    $provider = User::factory()->create(['role' => 'provider', 'is_verified' => true, 'profile_completed' => true]);
    
    $service = Service::create([
        'user_id' => $provider->id,
        'name' => 'Dry Waste Pickup Service',
        'category' => 'Recycling',
        'description' => 'Pickup dry waste',
        'type' => 'pickup',
        'price' => 1200,
        'unit' => 'kg',
        'duration' => '1 hour',
        'what_we_accept' => 'paper',
        'what_we_dont_accept' => 'food',
        'city' => 'Bengaluru',
        'status' => 'active',
    ]);

    $booking = Booking::create([
        'customer_id' => $customer->id,
        'provider_id' => $provider->id,
        'service_id' => $service->id,
        'scheduled_at' => '2026-06-01 09:00:00',
        'price' => 1200,
        'status' => 'confirmed',
        'payment_status' => 'paid',
    ]);

    $transaction = \App\Models\Transaction::create([
        'booking_id' => $booking->id,
        'amount' => 1200,
        'status' => 'completed',
    ]);

    $response = $this->actingAs($provider)->put(route('bookings.update', $booking->id), [
        'status' => 'cancelled',
    ]);

    $response->assertRedirect(route('bookings.index'));
    
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => 'cancelled',
        'payment_status' => 'refunded',
    ]);

    $this->assertDatabaseHas('transactions', [
        'id' => $transaction->id,
        'status' => 'refunded',
    ]);

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $customer,
        \App\Notifications\BookingRefundedNotification::class
    );
});
