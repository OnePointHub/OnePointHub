<?php

use App\Modules\Team\Controllers\InvitationsController;
use App\Modules\Team\Controllers\RegisteredUserController;
use App\Modules\Team\Controllers\TeamController;
use App\Modules\Team\Middleware\HasInvitation;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::name('team.')->prefix('team')->group(function () {
        Route::controller(TeamController::class)->group(function () {
            Route::get('/', 'Index')->name('index');
            Route::get('/{user}', 'edit')->name('edit');
            Route::patch('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

        Route::post('invite', [InvitationsController::class, 'store'])->name('invite');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register')->middleware(HasInvitation::class);

    Route::post('register', [RegisteredUserController::class, 'store']);
});
