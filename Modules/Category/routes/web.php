<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Admin\CategoryManagerController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::middleware('admin.auth')->group(function () {
        Route::resource('categories', CategoryManagerController::class);
        Route::post('categories/updateStatus', [CategoryManagerController::class, 'updateStatus'])->name('categories.updateStatus');
    });
});
