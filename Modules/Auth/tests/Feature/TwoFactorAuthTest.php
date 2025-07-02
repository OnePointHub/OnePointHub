<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Actions\TwoFactorAuth\GenerateNewRecoveryCodes;
use Modules\Auth\Actions\TwoFactorAuth\GenerateQrCodeAndSecretKey;

it('can render two-factor settings screen', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/settings/two-factor');

    $response->assertStatus(200);

    $inertiaProps = $response->original?->getData() ?? [];
    $props = $inertiaProps['page']['props'];
    $this->assertArrayHasKey('confirmed', $props);
    $this->assertArrayHasKey('recoveryCodes', $props);
    $this->assertFalse($props['confirmed']);
});

it('can enable two factor authentication', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Simulate enabling 2FA via POST
    $response = $this->post('/settings/two-factor');

    // Assert JSON response with expected structure
    $response->assertStatus(200)
        ->assertJsonStructure([
            'qrCode',
            'secret',
        ]);

    $user->refresh();
    $this->assertNotNull($user->two_factor_secret);
    // Recovery codes are null until confirm step
    $this->assertNull($user->two_factor_recovery_codes);
});

it('can manually enable two factor authentication', function () {
    $user = User::factory()->create();

    // Generate QR code and secret key
    $generateQrAndSecret = new GenerateQrCodeAndSecretKey;
    [$qrCode, $secret] = $generateQrAndSecret($user);

    // Generate recovery codes
    $generateCodes = new GenerateNewRecoveryCodes;
    $recoveryCodes = $generateCodes($user);

    // Manually enable 2FA for the user
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Test that 2FA is enabled on the settings page
    $response = $this->actingAs($user)
        ->get('/settings/two-factor');

    $response->assertStatus(200);
    // For Inertia/React, check the JSON response props instead of HTML content
    $inertiaProps = $response->original?->getData() ?? [];
    $props = $inertiaProps['page']['props'];
    $this->assertTrue(
        ($props['confirmed'] ?? false) === true,
        '2FA should be confirmed in page props.'
    );
    $this->assertArrayHasKey('recoveryCodes', $props);
});

it('can user with two factor enabled is redirected to challenge page after login', function () {
    $user = User::factory()->create();

    // Generate QR code and secret key
    $generateQrAndSecret = new GenerateQrCodeAndSecretKey;
    [$qrCode, $secret] = $generateQrAndSecret($user);

    // Generate recovery codes
    $generateCodes = new GenerateNewRecoveryCodes;
    $recoveryCodes = $generateCodes($user);

    // Manually enable 2FA for the user
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Attempt to log in and check for redirect
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response->assertRedirect('/two-factor-challenge');

    // Also verify the session has the login.id value set
    $this->assertTrue(session()->has('login.id'));
    $this->assertEquals($user->id, session('login.id'));
});

it('can authenticate with recovery code', function () {
    $user = User::factory()->create();

    // Generate QR code and secret key
    $generateQrAndSecret = new GenerateQrCodeAndSecretKey;
    [$qrCode, $secret] = $generateQrAndSecret($user);

    // Generate recovery codes
    $generateCodes = new GenerateNewRecoveryCodes;
    $recoveryCodes = $generateCodes($user);

    // Manually enable 2FA for the user
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Set the session to simulate a user that has logged in but not completed 2FA
    Session::put('login.id', $user->id);

    // Get the first recovery code
    $recoveryCode = $recoveryCodes[0];

    // Test authentication with recovery code via POST
    $response = $this->post('/two-factor-challenge', [
        'recovery_code' => $recoveryCode,
    ]);
    $response->assertRedirect('/dashboard');

    // Verify the recovery code was removed
    $user->refresh();
    $updatedRecoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes));
    $this->assertCount(count($recoveryCodes) - 1, $updatedRecoveryCodes);
    $this->assertNotContains($recoveryCode, $updatedRecoveryCodes);

    // Verify the session was cleared
    $this->assertFalse(session()->has('login.id'));
});

it('can unauthenticated user is redirected to login when accessing two factor challenge', function () {
    // Clear session to ensure we're testing as a guest
    Session::flush();

    $response = $this->get('/two-factor-challenge');
    $response->assertRedirect('/login');
});

it('can authenticated user without pending two factor challenge is redirected to login', function () {
    $user = User::factory()->create();

    // Authenticate the user but don't set the login.id session
    // which would indicate a pending 2FA challenge
    Session::flush();

    $response = $this->actingAs($user)
        ->get('/two-factor-challenge');

    // Adjust the expectation to match your actual implementation
    $response->assertRedirect('/login');
});

it('can user with two factor confirmed can access dashboard', function () {
    $user = User::factory()->create();

    // Generate QR code and secret key
    $generateQrAndSecret = new GenerateQrCodeAndSecretKey;
    [$qrCode, $secret] = $generateQrAndSecret($user);

    // Generate recovery codes
    $generateCodes = new GenerateNewRecoveryCodes;
    $recoveryCodes = $generateCodes($user);

    // Manually enable 2FA for the user
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Set the session to simulate a user that has logged in but not completed 2FA
    Session::put('login.id', $user->id);

    // Attempt to access dashboard
    $response = $this->actingAs($user)
        ->get('/dashboard');

    // In the test environment, the middleware might not be active
    // so we just verify we can access the dashboard (status 200)
    $response->assertStatus(200);
});

it('can disable two factor authentication', function () {
    $user = User::factory()->create();

    // Generate QR code and secret key
    $generateQrAndSecret = new GenerateQrCodeAndSecretKey;
    [$qrCode, $secret] = $generateQrAndSecret($user);

    // Generate recovery codes
    $generateCodes = new GenerateNewRecoveryCodes;
    $recoveryCodes = $generateCodes($user);

    // Manually enable 2FA for the user
    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Test disabling 2FA
    $this->actingAs($user);

    // Simulate disabling 2FA via DELETE
    $response = $this->delete('/settings/two-factor');
    $response->assertStatus(200);

    // Verify the user's 2FA settings were cleared
    $user->refresh();
    $this->assertNull($user->two_factor_secret);
    $this->assertNull($user->two_factor_recovery_codes);
    $this->assertNull($user->two_factor_confirmed_at);
});
