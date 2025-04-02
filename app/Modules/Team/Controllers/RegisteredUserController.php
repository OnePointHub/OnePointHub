<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Team\Models\UserInvitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(Request $request): Response
    {
        $invitation_token = $request->get('invitation_token');
        $invitation = UserInvitation::where('invitation_token', $invitation_token)->firstOrFail();
        $email = $invitation->email;

        return Inertia::render('authentication/Register', [
            'email' => $email,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $user->markEmailAsVerified();

        $this->registered($user);

        Auth::login($user);

        return to_route('dashboard');
    }

    /**
     * After user registration, update the user_invitation registered_at.
     */
    protected function registered(User $user): void
    {
        $invitation = UserInvitation::where('email', $user->email)->firstOrFail();
        $invitation->registered_at = $user->created_at;
        $invitation->save();
    }
}
