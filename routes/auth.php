<?php

Route::get('join/{token}', function () {
    return view('auth.join');
});
