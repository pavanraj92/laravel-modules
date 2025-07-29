<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Admin\AdminController;
use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Admin\Http\Controllers\Auth\ResetPasswordController;
use Modules\Admin\Http\Controllers\Auth\RegisterController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('admins', AdminController::class)->names('admin');
// });

Route::prefix('admin')->name('admin.')->namespace('Auth')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/send-reset-password-link', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'postResetPassword'])->name('password.update');


    Route::middleware('admin.auth')->group(function () {
        // Route::get('dashboard', function () {           
        //     return view('admin::admin.dashboard');
        // })->name('dashboard');

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/profile', [AdminController::class, 'viewProfile'])->name('profile');
        Route::post('/profileUpdate', [AdminController::class, 'profileUpdate'])->name('profileUpdate');
        Route::get('/change-password', [AdminController::class, 'viewChangePassword'])->name('change-password');
        Route::post('/updatePassword', [AdminController::class, 'updatePassword'])->name('updatePassword');

        Route::get('/packages', [AdminController::class, 'viewpackages'])->name('packages');
    });

});