<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Livewire\Livewire;
use Modules\Auth\Livewire\ForgotPassword;
use Modules\Auth\Livewire\ResetPassword as ResetPasswordLivewire;

it('can render reset password link screen', function () {
    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
});

it('can request reset password link', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});

it('can render reset password screen', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});

it('can reset password with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = Livewire::test(ResetPasswordLivewire::class, ['token' => $notification->token])
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('login', absolute: false));

        return true;
    });
});

it('cannot reset password with invalid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $response = Livewire::test(ResetPasswordLivewire::class, ['token' => 'wrong-token'])
        ->set('email', $user->email)
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('resetPassword');

    $response->assertSee('This password reset token is invalid.');
});
