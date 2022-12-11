<?php

namespace Database\Seeders;

use App\Models\BrandCategory;
use Illuminate\Database\Seeder;

class BrandCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BrandCategory::factory()->count(30)->create();
    }
}
