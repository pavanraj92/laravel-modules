<?php

use Illuminate\Support\Facades\Route;
use Modules\UserRole\Http\Controllers\UserRoleController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('userroles', UserRoleController::class)->names('userrole');
});
