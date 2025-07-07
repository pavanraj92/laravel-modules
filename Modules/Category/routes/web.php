<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('categories', CategoryController::class)->names('category');
// });


Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::post('category/updateStatus', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');
    });
});
