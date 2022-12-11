<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $brands = Brand::all()->pluck('id');
        $categories = Category::all()->pluck('id');

        return [
            'brand_id' => $this->faker->randomElement($brands),
            'category_id' => $this->faker->randomElement($categories)
        ];
    }
}
