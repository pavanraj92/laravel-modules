<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->updateOrInsert(
            ['slug' => 'customer'],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Customer role seeded successfully.');
    }
}
