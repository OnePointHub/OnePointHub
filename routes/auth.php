<?php

Route::get('register', function () {
    return view('auth.register');
});

Route::get('login', function () {
    return view('auth.login');
});

Route::get('forgot-password', function () {
    return view('auth.forgot-password');
});

Route::get('reset-password/{token}', function () {
    return view('auth.reset-password');
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
