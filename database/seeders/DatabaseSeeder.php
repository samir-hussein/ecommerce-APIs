<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            // CategorySeeder::class,
            // SubCategorySeeder::class,
            // BrandSeeder::class,
            // BrandCategorySeeder::class,
            // BrandSubCategorySeeder::class,
            // SellerSeeder::class,
            // CustomerSeeder::class,
            // CompanySeeder::class,
            // ProductSeeder::class,
            // ProductGallerySeeder::class,
            // ProductAttributeSeeder::class,
            // ProductAttributeValueSeeder::class,
        ]);
    }
}
