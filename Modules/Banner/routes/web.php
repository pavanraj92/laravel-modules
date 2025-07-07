<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\BannerManagerController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('banners', BannerManagerController::class);
    });
});
