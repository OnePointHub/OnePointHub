<?php

use App\Models\User;

it('can render confirm password screen', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});

it('can confirm password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

it('cannot confirm password with invalid password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
