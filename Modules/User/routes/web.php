<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::prefix('users/{type}')->name('users.')->group(function () {
        Route::resource('', UserController::class)->parameters([
            '' => 'user',
        ]);
        Route::post('updateStatus', [UserController::class, 'updateStatus'])->name('updateStatus');
    });
});
