<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminRolePermission\Http\Controllers\AdminRoleController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('adminrolepermissions', AdminRoleController::class)->names('adminrolepermission');
});
