<?php

namespace Modules\Auth\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Auth\Actions\TwoFactorAuth\CompleteTwoFactorAuthentication;
use Modules\Auth\Actions\TwoFactorAuth\GetTwoFactorAuthenticatableUser;
use Modules\Auth\Actions\TwoFactorAuth\ProcessRecoveryCode;
use Modules\Auth\Actions\TwoFactorAuth\VerifyTwoFactorCode;

#[Layout('components.layouts.guest')]
class TwoFactorChallenge extends Component
{
    public $recovery = false;

    #[Validate('required|min:6')]
    public $auth_code;
    public $recovery_code;

    public function mount()
    {
        if ( !session()->has('login.id')) {
            return redirect()->route('login');
        }
        $this->recovery = false;
    }

    #[On('submitCode')]
    public function submitCode($code)
    {
        $this->auth_code = $code;
        $this->validate();

        // Get the user that is in the process of 2FA
        $user = app(GetTwoFactorAuthenticatableUser::class)();

        if (!$user) {
            return redirect()->route('login');
        }

        $this->ensureIsNotRateLimited($user);

        // Verify the authentication code
        $valid = app(VerifyTwoFactorCode::class)(decrypt($user->two_factor_secret), $code);

        if ($valid) {
            // Complete the authentication process
            app(CompleteTwoFactorAuthentication::class)($user);

            // Clear rate limiter on successful authentication
            RateLimiter::clear($this->throttleKey($user));

            // Redirect to the intended page
            return $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        } else {
            RateLimiter::hit($this->throttleKey($user));
            $this->addError('auth_code', 'Invalid authentication code. Please try again.');
        }
    }

    public function submit_recovery_code()
    {
        // Get the user that is in the process of 2FA
        $user = app(GetTwoFactorAuthenticatableUser::class)();

        if (!$user) {
            return redirect()->route('login');
        }

        $this->ensureIsNotRateLimited($user);

        // Process the recovery code
        $updatedCodes = app(ProcessRecoveryCode::class)(json_decode(decrypt($user->two_factor_recovery_codes), true), $this->recovery_code);

        if ($updatedCodes !== false) {
            // Update the user's recovery codes in the database
            $user->forceFill([
                'two_factor_recovery_codes' => encrypt(json_encode($updatedCodes)),
            ])->save();

            // Complete the authentication process
            app(CompleteTwoFactorAuthentication::class)($user);

            // Clear rate limiter on successful authentication
            RateLimiter::clear($this->throttleKey($user));

            // Redirect to the intended page
            return $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        } else {
            RateLimiter::hit($this->throttleKey($user));
            $this->addError('recovery_code', 'This is an invalid recovery code. Please try again.');
        }
    }

    /**
     * Ensure the two-factor authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(User $user): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($user), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey($user));

        throw ValidationException::withMessages([
            'auth_code' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the two-factor challenge.
     */
    protected function throttleKey(User $user): string
    {
        return Str::transliterate($user->id . '|2fa');
    }

    public function render()
    {
        return view('auth::livewire.two-factor-challenge');
    }
}
