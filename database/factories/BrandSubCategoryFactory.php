<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
        $categories = Category::all();
        $brands = [];
        $subCategories = [];

        while (count($brands) < 1 || count($subCategories) < 1) {
            $index = random_int(0, count($categories) - 1);
            $brands = $categories[$index]->brands->pluck('id');
            $subCategories = $categories[$index]->subCategories->pluck('id');
        }

        return [
            'brand_id' => $this->faker->randomElement($brands),
            'sub_category_id' => $this->faker->randomElement($subCategories)
        ];
    }
}
