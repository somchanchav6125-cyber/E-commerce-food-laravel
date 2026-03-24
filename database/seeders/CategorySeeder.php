<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
$categories = [
    [
        'name' => 'អាហារខ្មែរ',
        'slug' => 'khmer-food',
        'description' => 'ម្ហូបខ្មែរប្រពៃណី',
        'parent_id' => null,
        'price' => 0,
        'stock' => 0,
    ],
    [
        'name' => 'ភេសជ្ជៈ',
        'slug' => 'drinks',
        'description' => 'ភេសជ្ជៈផ្សេងៗ',
        'parent_id' => null,
        'price' => 0,
        'stock' => 0,
    ],
    [
        'name' => 'អាហាររហ័ស',
        'slug' => 'fast-food',
        'description' => 'អាហាររហ័សបែបអន្តរជាតិ',
        'parent_id' => null,
        'price' => 0,
        'stock' => 0,
    ],
    [
        'name' => 'បង្អែមផ្លែឈើស្រស់',
        'slug' => 'Fruit Trifle/Bowl)',
        'description' => 'ផ្លែឈើស្រស់បែបអន្តរជាតិ',
        'parent_id' => null,
        'price' => 0,
        'stock' => 0,
    ],
];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']], // លក្ខខណ្ឌស្វែងរក
                $cat // ទិន្នន័យដែលត្រូវបង្កើតបើគ្មាន
            );
        }
    }
}
