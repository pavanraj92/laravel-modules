<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\App\Http\Controllers\Admin\FaqController;

Route::prefix('admin')->name('admin.')->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('faqs', FaqController::class);
        Route::post('faqs/updateStatus', [FaqController::class, 'updateStatus'])->name('faqs.updateStatus');
    });
});