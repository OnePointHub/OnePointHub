<?php

Route::middleware('guest')->group(function () {
});

Route::get('join/{token}', function () {
    return view('auth.join');
});

Route::get('verify-email', function () {
    return view('auth.verify-email');
});

Route::get('verify-email/{id}/{hash}', function () {
    return view('auth.verify-email');
});

Route::get('confirm-password', function () {
    return view('auth.confirm-password');
});
