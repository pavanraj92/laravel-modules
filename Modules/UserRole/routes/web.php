<?php

use Illuminate\Support\Facades\Route;
use Modules\UserRole\Http\Controllers\UserRoleController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('userroles', UserRoleController::class)->names('userrole');
});
