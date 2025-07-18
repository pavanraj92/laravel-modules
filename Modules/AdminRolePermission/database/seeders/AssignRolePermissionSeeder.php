<?php

use Illuminate\Database\Seeder;
use Modules\AdminRolePermission\App\Models\Role;
use Modules\AdminRolePermission\App\Models\Permission;

class AssignRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name', 'Super Admin')->first();

        if (!$role) {
            $this->command->warn('Super Admin role not found.');
            return;
        }

        $permissions = Permission::pluck('id')->toArray();

        $role->permissions()->syncWithoutDetaching($permissions);

        $this->command->info('All permissions assigned to Super Admin role.');
    }
}
