<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Admin\SettingManagerController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('settings', SettingManagerController::class);
});