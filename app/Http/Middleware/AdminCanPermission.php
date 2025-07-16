<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCanPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if the AdminRolePermission module exists
        $hasRoleModule = is_dir(base_path('Modules/AdminRolePermission'));
        $admin = auth('admin')->user();
        $allowed = (!$hasRoleModule && $admin)
            || ($hasRoleModule && $admin && method_exists($admin, 'hasPermission') && $admin->hasPermission($permission));

        if (!$allowed) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
