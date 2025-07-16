<?php

namespace Modules\AdminRolePermission\Database\Seeders;

use Illuminate\Database\Seeder;

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
            AssignAdminRoleSeeder::class,
        ]);
    }
}
