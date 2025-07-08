<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Admin\SettingManagerController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('settings', SettingManagerController::class);
    });
});