<?php

use Illuminate\Support\Facades\Route;
use Modules\Enquiry\Http\Controllers\Admin\EnquiryController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('enquiries', EnquiryController::class)->names('enquiry');
});
