<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = ProductAttribute::all()->pluck('id');

        return [
            'attr_val' => $this->faker->text(10),
            'product_attribute_id' => $this->faker->randomElement($product)
        ];
    }
}
