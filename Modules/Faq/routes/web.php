<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\App\Http\Controllers\Admin\FaqManagerController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('faqs', FaqManagerController::class);
    Route::post('faqs/updateStatus', [FaqManagerController::class, 'updateStatus'])->name('faqs.updateStatus');

});