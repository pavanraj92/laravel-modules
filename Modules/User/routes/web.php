<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Admin\UserManagerController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::prefix('users/{type}')->name('users.')->group(function () {
        Route::resource('', UserManagerController::class)->parameters([
            '' => 'user',
        ]);
        Route::post('updateStatus', [UserManagerController::class, 'updateStatus'])->name('updateStatus');
    });
});
