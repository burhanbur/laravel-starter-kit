<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::get('main', function () {
    return view('layouts.main');
});

// Testing route untuk error pages (hapus di production)
if (config('app.debug')) {
    Route::get('/test-error/{code}', function ($code) {
        // Validate HTTP status code
        if ($code < 100 || $code > 599) {
            abort(400, 'Invalid HTTP status code. Must be between 100-599');
        }
        abort($code, 'This is a test error message');
    })->where('code', '[0-9]+')->name('test.error');
}
