<?php

use App\Models\User;

it('can render profile screen', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $this->actingAs($user);

    $this->get('/settings/profile')->assertOk();
});

it('can update profile information', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->patch('/settings/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

it('does not change verification status when email address is unchanged', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->patch('/settings/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

it('can delete user account', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->delete('/settings/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

it('cannot delete user account with invalid password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->from('/settings/profile')
        ->delete('/settings/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/settings/profile');

    $this->assertNotNull($user->fresh());
});

it('can update password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/password');

    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});

it('cannot update password with invalid current password', function () {
    $user = User::whereEmail('admin@admin.com')->firstOrFail();

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/settings/password');
});

