<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard2');
    })->name('dashboard');
});

//Route::get('dashboard', function () {
//    return Inertia::render('Dashboard2');
//})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/authentication/routes.php';
require __DIR__.'/profile/routes.php';
require __DIR__.'/team/routes.php';
