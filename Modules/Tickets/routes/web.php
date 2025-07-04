<?php

use Illuminate\Support\Facades\Route;
use Modules\Tickets\Http\Controllers\TicketsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::name('tickets.')->prefix('tickets')->group(function () {
        Route::controller(TicketsController::class)->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
    });
});
