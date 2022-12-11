<?php

namespace Database\Seeders;

use App\Models\Product\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductAttribute::factory()->count(400)->create();
    }
}
