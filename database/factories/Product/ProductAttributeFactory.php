<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::all()->pluck('id');

        return [
            'attr_name' => $this->faker->text(10),
            'product_id' => $this->faker->randomElement($product)
        ];
    }
}
