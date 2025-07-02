<?php

namespace Modules\Auth\Actions\TwoFactorAuth;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateNewRecoveryCodes
{
    /**
     * Generate new recovery codes for the user.
     */
    public function __invoke(mixed $user): Collection
    {
        return Collection::times(8, function () {
            return $this->generate();
        });
    }

    public function generate(): string
    {
        return Str::random(10).'-'.Str::random(10);
    }
}
