<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Oli', 'description' => 'Oli kendaraan']);
        Category::create(['name' => 'Ban', 'description' => 'Ban motor dan mobil']);
        Category::create(['name' => 'Rantai', 'description' => 'Rantai motor']);
    }
}
