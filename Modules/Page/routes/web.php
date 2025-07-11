<?php

use Illuminate\Support\Facades\Route;
//use Modules\Page\Http\Controllers\PageController;
use Modules\Page\Http\Controllers\Admin\PageManagerController;


// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('pages', PageController::class)->names('page');
// });



Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('pages', PageManagerController::class);
    Route::post('pages/updateStatus', [PageManagerController::class, 'updateStatus'])->name('pages.updateStatus');
});