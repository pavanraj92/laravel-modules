<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\App\Http\Controllers\Admin\FaqManagerController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('faqs', FaqManagerController::class);
        Route::post('faqs/updateStatus', [FaqManagerController::class, 'updateStatus'])->name('faqs.updateStatus');
    });
});