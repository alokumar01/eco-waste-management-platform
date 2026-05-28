<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'SecretPassword123!',
        'password_confirmation' => 'SecretPassword123!',
        'role' => 'user',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('registration rejects weak passwords', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'weakpass',
        'password_confirmation' => 'weakpass',
        'role' => 'user',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['password']);
});
