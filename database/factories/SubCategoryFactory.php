<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = Category::all()->pluck('id');

        return [
            'name' => $this->faker->text(15),
            'category_id' => $this->faker->randomElement($categories)
        ];
    }
}
