<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminManager\Http\Controllers\AdminManagerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('adminmanagers', AdminManagerController::class)->names('adminmanager');
});
