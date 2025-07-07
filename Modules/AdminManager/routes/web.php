<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminManager\Http\Controllers\AdminManagerController;


Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('admins', AdminManagerController::class);
        Route::post('admins/updateStatus', [AdminManagerController::class, 'updateStatus'])->name('admins.updateStatus');
    });
});