<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    protected string $policyClass;

    public function isAble($ability, $targetModel): bool
    {
        try {
            Gate::authorize($ability, [$targetModel, $this->policyClass]);

            return true;
        } catch (AuthorizationException) {
            return false;
        }
    }
}
