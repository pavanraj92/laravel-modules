<?php

namespace Modules\Email\Database\Seeders;

use Illuminate\Database\Seeder;

class EmailDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        $this->call(MailDatabaseSeeder::class);
        $this->command->info('Email database seeded successfully.');
    }
}
