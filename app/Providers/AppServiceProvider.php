<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super-Admin" role all permissions
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        RedirectResponse::macro(
            'withSuccess',
            fn (string $message) => toast('success', $message, $this)
        );

        RedirectResponse::macro(
            'withError',
            fn (string $message) => toast('error', $message, $this)
        );
    }
}
