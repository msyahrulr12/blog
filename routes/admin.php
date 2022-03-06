<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/**
 * =======================================================
 * Admin Route
 * =======================================================
*/

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    

    // authenticated
    Route::middleware('auth')->group(function() {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /**
         * ===============================
         * Resource
         * ===============================
         * 
         */
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::resource('accounts', AccountController::class);
    });
});
