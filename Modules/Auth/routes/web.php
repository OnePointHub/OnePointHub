<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Livewire\Actions\Logout;
use Modules\Auth\Livewire\Login;
use Modules\Auth\Livewire\Register;

Route::middleware('guest')->group(function () {
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', Logout::class)->name('logout');
});
