<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Seo\App\Models\SeoMeta;

class SeoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('SEO Meta data seeded successfully.');
    }
}
