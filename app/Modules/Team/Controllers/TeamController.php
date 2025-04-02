<?php

namespace App\Modules\Team\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    protected string $policyClass = UserPolicy::class;

    /**
     * Display the "Team" page.
     */
    public function index(): Response
    {
        if ($this->isAble('manage-team', User::class)) {
            return Inertia::render('team/Index', [
                'members' => User::all(),
            ]);
        }

        return Inertia::render('errors/403');
    }

    /**
     * Show the form for editing team member.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('team/Edit', [
            'member' => $user,
        ]);
    }

    /**
     * Update team member.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'role' => [
                'required',
                'string',
                'in:member,admin',
            ],
            'status' => [
                'required',
                'string',
                'in:active,inactive',
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'status' => $validated['status'],
        ]);

        $user->syncRoles($validated['role']);

        return to_route('team.index')->withSuccess('Team member has been updated.');
    }

    /**
     * Delete team member.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return to_route('team.index')->withSuccess('Team member has been deleted.');
    }
}
