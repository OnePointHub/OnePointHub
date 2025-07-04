<?php

namespace Modules\Tickets\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        if ($user->can('tickets.view')) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->can('tickets.create')) {
            return true;
        }

        return false;
    }

    public function update(User $user): bool
    {
        if ($user->can('tickets.update')) {
            return true;
        }

        return false;
    }

    public function delete(User $user): bool
    {
        if ($user->can('tickets.delete')) {
            return true;
        }

        return false;
    }

    public function restore(User $user): bool
    {
        if ($user->can('tickets.restore')) {
            return true;
        }

        return false;
    }

    public function forceDelete(User $user): bool
    {
        if ($user->can('tickets.forceDelete')) {
            return true;
        }

        return false;
    }

    public function assign(User $user): bool
    {
        if ($user->can('tickets.assign')) {
            return true;
        }

        return false;
    }

    public function close(User $user): bool
    {
        if ($user->can('tickets.close')) {
            return true;
        }

        return false;
    }

    public function open(User $user): bool
    {
        if ($user->can('tickets.open')) {
            return true;
        }

        return false;
    }
}
