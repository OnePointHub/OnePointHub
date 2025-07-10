<?php

Route::middleware('guest')->group(function () {
});

Route::get('join/{token}', function () {
    return view('auth.join');
});

Route::get('confirm-password', function () {
    return view('auth.confirm-password');
});
