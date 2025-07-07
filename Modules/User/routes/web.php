<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/updateStatus', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    });
});
