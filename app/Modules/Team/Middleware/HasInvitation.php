<?php

namespace App\Modules\Team\Middleware;

use App\Modules\Team\Models\UserInvitation;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Only for GET request. Otherwise, this middleware will block registration.
         */
        if ($request->isMethod('GET')) {

            /**
             * No token = Goodbye.
             */
            if (! $request->has('invitation_token')) {
                return redirect('/');
            }

            $invitation_token = $request->get('invitation_token');

            /**
             * Let's try to find invitation by its token.
             */
            try {
                $invitation = UserInvitation::where('invitation_token', $invitation_token)->firstOrFail();
            } catch (ModelNotFoundException) {
                return redirect('/')->withError('Wrong Invitation Token!');
            }

            /**
             * Let's check if user is already registered.
             */
            if (! is_null($invitation->registered_at)) {
                return redirect('/')->withError('This Invitation is already registered!');
            }
        }

        return $next($request);
    }
}
