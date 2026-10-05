<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'SweetPetHome Administrator',
            'email' => 'sphadmin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User Demo
        User::create([
            'name' => 'Budi Petlover',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '08123456789',
            'address' => 'Jl. Mawar No. 10, Jakarta',
        ]);

        // Kategori
        $categories = [
            ['name' => 'Makanan Kering', 'type' => 'Foods - Dry'],
            ['name' => 'Makanan Basah', 'type' => 'Foods - Wet'],
            ['name' => 'Vitamin & Nutrisi', 'type' => 'Nutrient'],
            ['name' => 'Obat-obatan', 'type' => 'Medicine'],
            ['name' => 'Minuman', 'type' => 'Beverage'],
            ['name' => 'Perawatan', 'type' => 'Care - Clean'],
            ['name' => 'Snack & Treats', 'type' => 'Snack'],
            ['name' => 'Susu', 'type' => 'Milk'],
            ['name' => 'Fashion', 'type' => 'Fashion'],
            ['name' => 'Aksesoris', 'type' => 'Accessories'],
            ['name' => 'Mainan', 'type' => 'Toys'],
            ['name' => 'Aquarium Ikan', 'type' => 'Hewan - Ikan'],
            ['name' => 'Kandang', 'type' => 'Hewan - Kandang'],
        ];
        foreach ($categories as $c) {
            Category::create([...$c, 'slug' => Str::slug($c['name'])]);
        }

        // Contoh produk
        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'category_id' => rand(1, 13),
                'name' => "Produk Pet $i",
                'brand' => ['Whiskas', 'Pedigree', 'Me-O', 'Kittie Bittie', 'Cat Choize', 'Excel', 'Cattie Rare', 'ProPlan', 'Nature Bridge', 'Cleo', 'Royal Canin', 'Purina'][rand(0, 11)],
                'description' => 'Produk berkualitas untuk hewan kesayangan Anda.',
                'price' => rand(20000, 500000),
                'stock' => rand(5, 100),
                'sold' => rand(0, 200),
                'image' => null,
                'is_best_seller' => $i <= 5,
            ]);
        }
    }
}
