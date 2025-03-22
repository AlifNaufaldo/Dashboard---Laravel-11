<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::insert([
            ['name' => 'Budi Santoso', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No. 1', 'email' => 'budi@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ani Rahmawati', 'phone' => '081298765432', 'address' => 'Jl. Sudirman No. 2', 'email' => 'ani@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}