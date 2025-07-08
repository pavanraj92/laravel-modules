<?php

use Illuminate\Support\Facades\Route;
use Modules\UserRole\App\Http\Controllers\Admin\UserRoleManagerController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('user_roles', UserRoleManagerController::class);
        Route::post('user_roles/updateStatus', [UserRoleManagerController::class, 'updateStatus'])->name('user_roles.updateStatus');
    });
});