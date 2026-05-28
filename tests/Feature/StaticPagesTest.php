<?php

test('terms page returns a successful response', function () {
    $response = $this->get(route('public.terms'));
    $response->assertStatus(200);
});

test('privacy page returns a successful response', function () {
    $response = $this->get(route('public.privacy'));
    $response->assertStatus(200);
});

test('refund policy page returns a successful response', function () {
    $response = $this->get(route('public.refund-policy'));
    $response->assertStatus(200);
});

test('faqs page returns a successful response', function () {
    $response = $this->get(route('public.faqs'));
    $response->assertStatus(200);
});

test('help page returns a successful response', function () {
    $response = $this->get(route('public.help'));
    $response->assertStatus(200);
});

test('help message admin redirects provider to message show with admin', function () {
    $provider = \App\Models\User::factory()->create(['role' => 'provider', 'status' => 'active']);
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $response = $this->actingAs($provider)->get(route('help.message-admin'));

    $response->assertRedirect(route('messages.show', $admin->id));
});

test('help message admin redirects customer to message show with admin', function () {
    $customer = \App\Models\User::factory()->create(['role' => 'user', 'status' => 'active']);
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $response = $this->actingAs($customer)->get(route('help.message-admin'));

    $response->assertRedirect(route('customer.messages.show', $admin->id));
});
