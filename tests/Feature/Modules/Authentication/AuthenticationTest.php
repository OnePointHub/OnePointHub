<?php

use App\Models\User;

it('can render login screen', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

it('can authenticate user', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->post(route('login', [
        'email' => $user->email,
        'password' => 'password',
    ]));

    $this->assertAuthenticatedAs($user);

    $response->assertRedirect(route('dashboard', absolute: false));
});

it('cannot authenticate user with invalid password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->post(route('login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]));

    $response->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('can logout user', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    $this->assertGuest();
});

it('can rate limit on multiple login attempts', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $i = 1;
    while ($i <= 61) {
        $this->post(route('login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]));

        $i++;
    }

    $response = $this->post(route('login', [
        'email' => $user->email,
        'password' => 'password',
    ]));

    $response->assertSessionHasErrors('email');
});
