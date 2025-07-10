<?php

namespace Modules\Auth\Actions\TwoFactorAuth;

class ConfirmTwoFactorAuthentication
{
    /**
     * Confirm two-factor authentication for the user.
     *
     * @param mixed $user
     * @return bool
     */
    public function __invoke(mixed $user): bool
    {
        $user->forceFill([
            'two_factor_confirmed_at' => now(),
        ])->save();

        return true;
    }
}
