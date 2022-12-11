<?php

namespace Database\Seeders;

use App\Models\Product\ProductAttributeValue;
use Illuminate\Database\Seeder;

class ProductAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductAttributeValue::factory()->count(800)->create();
    }
}
