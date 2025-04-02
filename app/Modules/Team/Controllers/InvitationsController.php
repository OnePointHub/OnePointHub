<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Team\Models\UserInvitation;
use App\Modules\Team\Notifications\UserInvited;
use App\Modules\Team\Requests\StoreInvitationRequest;
use App\Policies\UserPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class InvitationsController extends Controller
{
    protected string $policyClass = UserPolicy::class;

    /**
     * Handle an incoming invitation request.
     *
     * @throws ValidationException
     */
    public function store(StoreInvitationRequest $request): Response|RedirectResponse
    {
        if ($this->isAble('invite', User::class)) {
            if (User::whereEmail($request->email)->exists()) {
                return back()->withError('A user with that email already exists.');
            }
            $invitation = new UserInvitation($request->all());
            $invitation->generateInvitationToken();
            $invitation->save();

            Notification::route('mail', $invitation->email)
                ->notify(new UserInvited($request->user(), $invitation));

            return back()->withSuccess('Invitation sent.');
        }

        return Inertia::render('errors/403');
    }
}
