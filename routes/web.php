<?php

use App\Http\Controllers\Main\AuthController;
use App\Http\Controllers\Main\DashboardController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->middleware('guest');
    Route::post('/login', 'login')->name('login');

    Route::get('/logout', 'logout')->name('logout');
});



Route::middleware('auth')->group(function () {
    // DASHBOARD
    Route::controller(DashboardController::class)->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard.admin');
        });
    });
});
