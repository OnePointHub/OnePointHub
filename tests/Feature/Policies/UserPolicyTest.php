<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('cannot manage team without permission', function () {
    $user = User::factory()->create();
    $user->assignRole('member');

    $response = $this->actingAs($user)
        ->get(route('team.index'));

    $response
        ->assertInertia(fn (Assert $page) => $page
            ->component('errors/403'));
});

it('cannot invite team member without permission', function () {
    $user = User::factory()->create();
    $user->assignRole('member');

    $response = $this->actingAs($user)
        ->post(route('team.invite'), [
            'email' => 'johndoe@example.com',
        ]);

    $response
        ->assertInertia(fn (Assert $page) => $page
            ->component('errors/403'));
});
