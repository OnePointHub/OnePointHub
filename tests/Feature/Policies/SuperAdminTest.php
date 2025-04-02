<?php

use App\Models\User;

it('can access everything if Super-Admin', function () {
     $user = User::factory()->create();
     $user->assignRole('super-admin');

     $response = $this->actingAs($user)->get(route('team.index'));

     $response->assertOk();
});
