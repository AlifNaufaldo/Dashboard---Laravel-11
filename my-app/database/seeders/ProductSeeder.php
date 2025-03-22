<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            ['name' => 'Oli X', 'category_id' => 1, 'stock' => 50, 'price' => 75000, 'description' => 'Oli motor kualitas tinggi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ban Tubeless', 'category_id' => 2, 'stock' => 30, 'price' => 200000, 'description' => 'Ban motor anti bocor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rantai Motor', 'category_id' => 3, 'stock' => 40, 'price' => 120000, 'description' => 'Rantai motor kuat dan awet', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
