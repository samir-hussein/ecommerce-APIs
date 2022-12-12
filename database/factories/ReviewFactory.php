<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::all()->pluck('id');
        $customer = Customer::all()->pluck('id');

        return [
            'comment' => $this->faker->optional($weight = 0.3)->text(200),
            'rating' => $this->faker->numberBetween(0, 5),
            'product_id' => $this->faker->randomElement($product),
            'customer_id' => $this->faker->randomElement($customer)
        ];
    }
}
