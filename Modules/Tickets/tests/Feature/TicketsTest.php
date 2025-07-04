<?php

use App\Models\User;
use Modules\Tickets\Database\Seeders\TicketsPermissionsSeeder;

it('can show create ticket screen', function () {
    $this->seed(TicketsPermissionsSeeder::class);

    $user = User::factory()->create();

    $user->assignRole('tickets.agent');

    $this->actingAs($user)
        ->get(route('tickets.create'))
        ->assertOk();
});

it('cannot show create ticket screen when guest', function () {
    $this->get(route('tickets.create'))
    ->assertRedirect(route('login'));
});

it('cannot show create ticket screen without permission', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tickets.create'))
        ->assertForbidden();
});

it('can create a ticket', function () {
    $this->seed(TicketsPermissionsSeeder::class);

    $user = User::factory()->create();

    $user->assignRole('tickets.agent');

    $this->actingAs($user)
        ->post(route('tickets.store'),[
            'subject' => 'Test ticket',
            'description' => 'Test ticket',
            'priority' => 'Low',
        ])
        ->assertRedirect(route('tickets.create'));

    $this->assertDatabaseHas('tickets', [
        'subject' => 'Test ticket',
    ]);
});

it('cannot create a ticket without permission', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tickets.store'),[
            'subject' => 'Test ticket',
            'description' => 'Test ticket',
            'priority' => 'Low',
        ])
        ->assertForbidden();
});

it('cannot create a ticket when guest', function () {
    $this->post(route('tickets.store'),[
        'subject' => 'Test ticket',
        'description' => 'Test ticket',
        'priority' => 'Low',
    ])
        ->assertRedirect(route('login'));
});
