<?php

use App\Models\User;

it('can get user role attribute', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    expect($user->role)->toBe('admin');
});

it('can get user last_active attribute', function () {
    $user = User::factory()->create();
    expect($user->last_active)->toBe('Never');

    $user->last_active_at = now();
    expect($user->last_active)->toBe('Just now');

    $user->last_active_at = now()->subMinutes(60);
    expect($user->last_active)->toBe('1 hour ago');
});
