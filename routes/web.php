<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('auth.login');
});

// auth routes
Route::prefix('auth')->as('auth.')->group(function () {
    Route::middleware('auth')->group(function () {
        // login
        Route::get('/login', [AuthController::class, 'loginView'])->name('login.show');
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        // registration
        Route::get('/sign-up', [AuthController::class, 'signupView'])->name('signup.show');
        Route::post('/sign-up', [AuthController::class, 'signup'])->name('signup');

        // forgot password
        Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('forgot-password.show');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

        // reset password
        Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('reset-password.show');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    });

    // profile
    Route::get('/profile', [AuthController::class, 'profileView'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('avatar.update');

    // logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// admin routes
Route::prefix('admin')->as('admin.')->middleware('isAdmin')->group(function () {
    // dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // user routes
    Route::resource('users', UserController::class);
    Route::as('users.')->group(function () {
        // Role resource routes
        Route::resource('roles', RoleController::class);

        // Additional route for updating permissions within roles
        Route::post('/roles/{role}/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

        // Permission resource routes
        Route::resource('permissions', PermissionController::class);
    });

    // setting routes
    Route::prefix('/settings')->as('settings.')->controller(SettingController::class)->group(function () {
        Route::get('/{type}/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');

        Route::prefix('/sms/providers')->as('sms.')->group(function () {
            Route::get('/{name}', 'smsProvider');
            Route::post('/update', 'updateSmsProviders')->name('providers.update');
            Route::get('/test/{provider}', [SmsController::class, 'testSms']);
        });
    });
});
  
// test routes
Route::get('/test', [TestController::class, 'index']);
