<?php

namespace Modules\AdminRolePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRolePermission\App\Models\Role;
use Modules\Admin\Models\Admin;

class AssignAdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        if (!$admin) {
            //create a super admin if none exists according to Modules\Admin\Models\Admin
            $admin = Admin::create([
                // 'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@yopmail.com',
                'mobile' => '1234567890',
                'website_name' => 'Super Admin Website',
                'website_slug' => 'super-admin-website',
                'password' => bcrypt('Dots@123'),
                'status' => 1,
            ]);
        }

        // Get or create a role
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'status' => 1]);

        // Attach role to admin (pivot table: role_admin)
        $admin->roles()->syncWithoutDetaching([$role->id]);

        $this->command->info("Assigned '{$role->name}' role to admin: {$admin->email}");
    }
}
