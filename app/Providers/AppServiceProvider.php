<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade directive for admin permission checks (single or multiple)
        Blade::if('admincan', function ($permissions) {
            // Check if the AdminRolePermission module exists
            $hasRoleModule = is_dir(base_path('Modules/AdminRolePermission'));
            $admin = auth('admin')->user();
            if (!$admin) {
                return false;
            }

            $permissionArray = explode('|', $permissions);

            foreach ($permissionArray as $permission) {
                $permission = trim($permission);
                if (!$hasRoleModule) {
                    return true; // if no role-permission module, allow access
                }

                if (method_exists($admin, 'hasPermission') && $admin->hasPermission($permission)) {
                    return true; // allow if user has at least one
                }
            }

            return false; // deny if none matched
        });
    }
}
