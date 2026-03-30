<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        // Images already exist in storage/app/public/products/
        $images = [
            'amok-trey' => 'amok-trey.jpg',
            'prahok-khtis' => 'prahok-khtis.jpg',
            'samlor-korkor' => 'samlor-korkor.jpg',
            'nom-banh-chok' => 'nom-banh-chok.jpg',
            'bai-cha' => 'bai-cha.jpg',
            'orange-juice' => 'orange-juice.jpg',
            'coconut-water' => 'coconut-water.jpg',
            'sugarcane-juice' => 'sugarcane-juice.jpg',
            'mango-smoothie' => 'mango-smoothie.jpg',
            'burger' => 'burger.jpg',
            'pizza' => 'pizza.jpg',
            'fried-chicken' => 'fried-chicken.jpg',
            'french-fries' => 'french-fries.jpg',
            'fresh-bread' => 'fresh-bread.jpg',
            'cake' => 'cake.jpg',
        ];

        foreach ($products as $product) {
            if (isset($images[$product->slug])) {
                $imageName = $images[$product->slug];

                // Check if image exists in storage
                if (Storage::disk('public')->exists('products/' . $imageName)) {
                    $product->update([
                        'image' => 'products/' . $imageName
                    ]);
                    $this->command->info("Added image for: {$product->name}");
                } else {
                    $this->command->warn("Image not found for: {$product->name} (products/{$imageName})");
                }
            }
        }

        $this->command->info('Product image seeding completed!');
    }
}
