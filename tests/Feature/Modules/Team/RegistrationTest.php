<?php

use App\Modules\Team\Models\UserInvitation;

it('can render registration screen', function () {
    $invitation = UserInvitation::create([
        'email' => 'john@doe.com',
    ]);
    $invitation->generateInvitationToken();
    $invitation->save();

    $link = $invitation->getLink();

    $response = $this->get($link);

    $response->assertStatus(200);
});

it('can register new user', function () {
    $invitation = UserInvitation::create([
        'email' => 'john@doe.com',
    ]);
    $invitation->generateInvitationToken();
    $invitation->save();

    $link = $invitation->getLink();

    $response = $this
        ->from($link)
        ->post('/register', [
            'name' => 'Test User',
            'email' => $invitation->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

it('cannot access register Screen without invitation_token', function () {
    $response = $this->get(route('register'));

    $response->assertRedirect('/');
});

it('cannot access register Screen with invalid invitation_token', function () {
    $response = $this->get(route('register', [
        'invitation_token' => 'random-token',
    ]));

    $response->assertRedirect('/');
});

it('cannot access register Screen if already registered', function () {
    $invitation = UserInvitation::create([
        'email' => 'john@doe.com',
    ]);
    $invitation->generateInvitationToken();
    $invitation->registered_at = now();
    $invitation->save();
    $link = $invitation->getLink();
    $response = $this->get($link);

    $response->assertRedirect('/');
});
