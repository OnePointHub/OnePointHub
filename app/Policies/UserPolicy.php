<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can manage team members.
     */
    public function manageTeam(User $user): bool
    {
        if ($user->can('manage team')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can invite new users.
     */
    public function invite(User $user): bool
    {
        if ($user->can('invite member')) {
            return true;
        }

        return false;
    }
}
