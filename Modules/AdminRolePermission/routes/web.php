<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminRolePermission\Http\Controllers\AdminRoleController;
use Modules\AdminRolePermission\Http\Controllers\AdminPermissionController;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin.permission:role_list'])->group(function () {
    Route::resource('roles', AdminRoleController::class);
    
    Route::resource('permissions', AdminPermissionController::class);
    Route::post('updateStatus', [AdminPermissionController::class, 'updateStatus'])->name('updateStatus');

    // Assign Permissions to Role
    Route::get('roles/{role}/assign-permissions', [AdminRoleController::class, 'editPermissionsAssign'])->name('roles.assign.permissions.edit');
    Route::post('roles/{role}/assign-permissions', [AdminRoleController::class, 'updatePermissionsAssign'])->name('roles.assign.permissions.update');

    // Assign Admins to Role
    Route::get('roles/{role}/assign-admins', [AdminRoleController::class, 'editAssignAdminsRoles'])->name('roles.assign.admins.edit');
    Route::post('roles/{role}/assign-admins', [AdminRoleController::class, 'updateAssignAdminsRoles'])->name('roles.assign.admins.update');
});
