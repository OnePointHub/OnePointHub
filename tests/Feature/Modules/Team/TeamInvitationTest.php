<?php

use App\Models\User;

it('can send invitation', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)
        ->post(route('team.invite'), [
            'email' => 'jon@doe.com',
        ]);

    $this->assertDatabaseHas('user_invitations', ['email' => 'jon@doe.com']);

    $response->assertStatus(302);
});

it('cannot send invitation if user already exists', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    User::factory()->create(['email' => 'jon@doe.com']);
    $response = $this->actingAs($user)
        ->post(route('team.invite'), [
            'email' => 'jon@doe.com',
        ]);

    $response->assertRedirect();
});

