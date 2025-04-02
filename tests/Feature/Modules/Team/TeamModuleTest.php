<?php

use App\Models\User;

it('can render Team screen', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)
        ->get(route('team.index'));

    $response->assertStatus(200);
});

it('can render Team Edit screen', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)
        ->get(route('team.edit', $user));

    $response->assertStatus(200);
});

it('can update Team member', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $member = User::factory()->create([
        'email' => 'jon@doe.com',
    ]);

    $response = $this->actingAs($user)
        ->patch(route('team.update', $user), [
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com',
            'phone' => null,
            'location' => null,
            'role' => 'member',
            'status' => 'active',
        ]);

    $response->assertRedirect(route('team.index'));
});

it('can delete Team member', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $member = User::factory()->create();

    $response = $this->actingAs($user)
        ->delete(route('team.destroy', $member));

    $response->assertRedirect(route('team.index'));

    $this->assertModelMissing($member);
});
