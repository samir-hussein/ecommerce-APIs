<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandSubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $brands = Brand::all()->pluck('id');
        $subCategories = SubCategory::all()->pluck('id');

        return [
            'brand_id' => $this->faker->randomElement($brands),
            'sub_category_id' => $this->faker->randomElement($subCategories)
        ];
    }
}
