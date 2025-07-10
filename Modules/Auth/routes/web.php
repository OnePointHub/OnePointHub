<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\VerifyEmailController;
use Modules\Auth\Livewire\Actions\Logout;
use Modules\Auth\Livewire\ForgotPassword;
use Modules\Auth\Livewire\Login;
use Modules\Auth\Livewire\Register;
use Modules\Auth\Livewire\ResetPassword;
use Modules\Auth\Livewire\VerifyEmail;

Route::middleware('guest')->group(function () {
    Route::get('register', Register::class)->name('register');
    Route::get('login', Login::class)->name('login');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('logout', Logout::class)->name('logout');
});
