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
        $fruitCategory = Category::where('slug', 'Fruit Trifle/Bowl')->first();

        $products = [
            // Khmer Food
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'អាម៉ុកត្រី',
                'slug' => 'amok-trey',
                'description' => 'ម្ហូបខ្មែរប្រពៃណីធ្វើពីត្រី និងគ្រឿងផ្សំផ្សេងៗ',
                'price' => 5.99,
                'stock' => 10,
            ],
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'ប្រហុកខ្ទិះ',
                'slug' => 'prahok-khtis',
                'description' => 'ម្ហូបខ្មែរប្រពៃណីធ្វើពីប្រហុក និងខ្ទិះដូង',
                'price' => 4.50,
                'stock' => 15,
            ],
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'សម្លកកូរ',
                'slug' => 'samlor-korkor',
                'description' => 'សម្លខ្មែរប្រពៃណីមានបន្លែច្រើនមុខ',
                'price' => 6.50,
                'stock' => 12,
            ],
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'នំបញ្ចុក',
                'slug' => 'nom-banh-chok',
                'description' => 'នំបញ្ចុកសម្លខ្មៀវ',
                'price' => 3.50,
                'stock' => 20,
            ],
            [
                'category_id' => $khmerCategory->id ?? 1,
                'name' => 'បាយឆា',
                'slug' => 'bai-cha',
                'description' => 'បាយឆាជាមួយសាច់គោ ឬសាច់ជ្រូក',
                'price' => 4.00,
                'stock' => 25,
            ],
            // Drinks
            [
                'category_id' => $drinksCategory->id ?? 2,
                'name' => 'ទឹកក្រូចច្របាច់',
                'slug' => 'orange-juice',
                'description' => 'ទឹកក្រូចច្របាច់ស្រស់ៗ',
                'price' => 2.50,
                'stock' => 30,
            ],
            [
                'category_id' => $drinksCategory->id ?? 2,
                'name' => 'ទឹកដូង',
                'slug' => 'coconut-water',
                'description' => 'ទឹកដូងក្រអូបឆ្ងាញ់',
                'price' => 2.00,
                'stock' => 40,
            ],
            [
                'category_id' => $drinksCategory->id ?? 2,
                'name' => 'ទឹកអំពិល',
                'slug' => 'sugarcane-juice',
                'description' => 'ទឹកអំពិលផ្អែមឆ្ងាញ់',
                'price' => 1.50,
                'stock' => 35,
            ],
            [
                'category_id' => $drinksCategory->id ?? 2,
                'name' => 'ទឹកស្វាយ',
                'slug' => 'mango-smoothie',
                'description' => 'ទឹកស្វាយឆ្ងាញ់',
                'price' => 3.00,
                'stock' => 25,
            ],
            // Fast Food
            [
                'category_id' => $fastfoodCategory->id ?? 3,
                'name' => 'ប៊ឺហ្គឺ',
                'slug' => 'burger',
                'description' => 'ប៊ឺហ្គឺសាច់គោឆ្ងាញ់',
                'price' => 5.50,
                'stock' => 20,
            ],
            [
                'category_id' => $fastfoodCategory->id ?? 3,
                'name' => 'ផីហ្សា',
                'slug' => 'pizza',
                'description' => 'ផីហ្សាសាច់ជ្រូក និងប៉េប៉រនី',
                'price' => 8.99,
                'stock' => 15,
            ],
            [
                'category_id' => $fastfoodCategory->id ?? 3,
                'name' => 'មាន់ចៀន',
                'slug' => 'fried-chicken',
                'description' => 'មាន់ចៀនស្រួយ',
                'price' => 6.50,
                'stock' => 18,
            ],
            [
                'category_id' => $fastfoodCategory->id ?? 3,
                'name' => 'បារាំងចៀន',
                'slug' => 'french-fries',
                'description' => 'ដំឡូងបារាំងចៀន',
                'price' => 2.50,
                'stock' => 50,
            ],
            // Fruit Trifle
            [
                'category_id' => $fruitCategory->id ?? 4,
                'name' => 'នំប៉័ងស្រស់',
                'slug' => 'fresh-bread',
                'description' => 'នំប៉័ងស្រស់ថ្មី',
                'price' => 1.50,
                'stock' => 30,
            ],
            [
                'category_id' => $fruitCategory->id ?? 4,
                'name' => 'នំចំណី',
                'slug' => 'cake',
                'description' => 'នំចំណីផ្អែម',
                'price' => 3.50,
                'stock' => 20,
            ],
             [
                'category_id' => $fruitCategory->id ?? 4,
                'name' => 'នំចំណី',
                'slug' => 'cake',
                'description' => 'នំចំណីផ្អែម',
                'price' => 3.50,
                'stock' => 20,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
