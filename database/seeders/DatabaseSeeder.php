<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // បង្កើត admin ប្រសិនបើមិនទាន់មាន
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123',
                'role' => 'admin',
            ]
        );

        // បើចង់បានអ្នកប្រើសាកល្បងក៏បាន
        User::firstOrCreate(
            ['email' => 'default@example.com'],
            [
                'name' => 'Default User',
                'password' => 'password',
                'role' => 'user',
            ]
        );

        // ហៅ seeders ផ្សេងទៀត (បើមាន)
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
