<?php

namespace Database\Seeders;

use App\Models\BrandSubCategory;
use Illuminate\Database\Seeder;

class BrandSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BrandSubCategory::factory()->count(30)->create();
    }
}
