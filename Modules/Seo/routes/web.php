<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\App\Http\Controllers\Admin\SeoManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('seo', SeoManagerController::class);
});
