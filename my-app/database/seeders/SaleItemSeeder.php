<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SaleItem;

class SaleItemSeeder extends Seeder
{
    public function run(): void
    {
        SaleItem::insert([
            ['sale_id' => 1, 'product_id' => 1, 'quantity' => 2, 'unit_price' => 75000, 'subtotal' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['sale_id' => 1, 'product_id' => 2, 'quantity' => 1, 'unit_price' => 125000, 'subtotal' => 125000, 'created_at' => now(), 'updated_at' => now()],
            ['sale_id' => 2, 'product_id' => 3, 'quantity' => 2, 'unit_price' => 160000, 'subtotal' => 320000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
