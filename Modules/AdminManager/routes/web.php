<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminManager\Http\Controllers\Admin\AdminManagerController;


Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('admins', AdminManagerController::class);
    Route::post('admins/updateStatus', [AdminManagerController::class, 'updateStatus'])->name('admins.updateStatus');

});