<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\RolesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles', RolesController::class)->names('roles');
});
