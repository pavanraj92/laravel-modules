<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\Admin\BannerManagerController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('banners', BannerManagerController::class);
    Route::post('banners/updateStatus', [BannerManagerController::class, 'updateStatus'])->name('banners.updateStatus');
});
