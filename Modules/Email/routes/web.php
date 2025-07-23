<?php

use Illuminate\Support\Facades\Route;
// use Modules\Email\Http\Controllers\EmailController;
use Modules\Email\App\Http\Controllers\Admin\EmailManagerController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('emails', EmailController::class)->names('email');
// });

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('emails', EmailManagerController::class);
    Route::post('emails/updateStatus', [EmailManagerController::class, 'updateStatus'])->name('emails.updateStatus');

});
