<?php

namespace Modules\AdminRolePermission\Database\Seeders;

use AssignRolePermissionSeeder;
use Illuminate\Database\Seeder;
use Modules\AdminRolePermission\Database\Seeders\AssignRolePermissionSeeder as SeedersAssignRolePermissionSeeder;

class AdminRolePermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AdminPermissionSeeder::class,
            AdminRoleSeeder::class,
            SeedersAssignRolePermissionSeeder::class,
            AssignAdminRoleSeeder::class,
        ]);
    }
}
