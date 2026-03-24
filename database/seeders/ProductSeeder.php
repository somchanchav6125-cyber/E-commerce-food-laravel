<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $khmerCategory = Category::where('slug', 'khmer-food')->first();
        $drinksCategory = Category::where('slug', 'drinks')->first();
        $fastfoodCategory = Category::where('slug', 'fast-food')->first();

        $products = [
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'អាម៉ុកត្រី',
                'slug' => 'amok-trey',
                'description' => 'ម្ហូបខ្មែរប្រពៃណីធ្វើពីត្រី និងគ្រឿងផ្សំផ្សេងៗ',
                'price' => 5.99,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'ប្រហុកខ្ទិះ',
                'slug' => 'prahok-khtis',
                'description' => 'ម្ហូបខ្មែរប្រពៃណីធ្វើពីប្រហុក និងខ្ទិះដូង',
                'price' => 4.50,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $drinksCategory->id ?? 2,
                'name' => 'ទឹកក្រូចច្របាច់',
                'slug' => 'orange-juice',
                'description' => 'ទឹកក្រូចច្របាច់ស្រស់ៗ',
                'price' => 2.50,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
