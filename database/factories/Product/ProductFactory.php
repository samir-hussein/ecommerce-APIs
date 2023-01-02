<?php

namespace Database\Factories\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Seller;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $img = [
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785926/images/product_gallery_pKnEXVb6bYDGJYrSwBRK.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785922/images/product_gallery_jHbPBrjCBhVbYgbyKkHw.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785920/images/product_gallery_iAAslwenlcnMXK3OSmNH.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785918/images/product_gallery_POQvGQ9pCgt0ceKY80kg.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785914/images/product_gallery_xFJTMcoEn6ol46ENJobq.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785912/images/product_gallery_0VtjPoZ2RzYSsLGZNztH.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785904/images/product_gallery_wdo5haBqYOXIImAHoMq4.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785907/images/product_gallery_rVvDq7KMcHQkllvRHeRR.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785909/images/product_gallery_9VRHJlOEx3RWIVENpZlW.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785898/images/product_gallery_kvfHGlXOtA2qofc5yzH4.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785899/images/product_gallery_LdxJiTX0PhO7tpJnMMES.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785902/images/product_gallery_I7YURPcxopeIP6egBAdh.jpg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785437/images/product_cvU1fuQfLtWy6gEcoFLD.jpeg.jpg',
            'https://res.cloudinary.com/dvcw17rg2/image/upload/v1670785895/images/product_7OcZNxBJb7XqVfDxWtnB.jpg.jpg'
        ];

        $sellers = Seller::all()->pluck('id');
        $categories = Category::all();
        $index = random_int(0, count($categories) - 1);
        $category = $categories[$index];
        $category_id = $category->id;
        $subCategories = $category->subCategories;
        $index = random_int(0, count($subCategories) - 1);
        $subCategory = $subCategories[$index];
        $brands = $subCategory->brands->pluck('id');
        $subCategory_id = $subCategory->id;


        return [
            'name' => $this->faker->text(15),
            'img' => 'image',
            'secure_url' => $this->faker->randomElement($img),
            'price' => $this->faker->numberBetween(50, 6000),
            'description' => $this->faker->text(200),
            'discount' => $this->faker->numberBetween(0, 40),
            'stock' => $this->faker->numberBetween(0, 200),
            'approved' => $this->faker->randomElement(['approved', 'pending']),
            'category_id' => "$category_id",
            'sub_category_id' => $this->faker->randomElement([$subCategory_id, null]),
            'brand_id' => $this->faker->optional()->randomElement($brands),
            'seller_id' => $this->faker->randomElement($sellers),
        ];
    }
}
