<?php

use Modules\Auth\Livewire\Register;

it('can render registration screen', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

it('can register new users', function () {
    $response = Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@doe.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
