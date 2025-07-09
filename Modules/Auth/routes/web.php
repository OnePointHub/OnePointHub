<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Livewire\Register;

Route::middleware('guest')->group(function () {
    Route::get('register', Register::class)->name('register');
});

