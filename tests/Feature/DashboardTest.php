<?php

use App\Models\User;

it('can render dashboard page', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this->actingAs($user)->get(route('dashboard'));
    $response->assertOk();
});
