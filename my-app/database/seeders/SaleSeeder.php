<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['customer_name' => 'Budi Santoso', 'user_id' => 1, 'sale_date' => now(), 'total_amount' => 275000, 'payment_method' => 'cash', 'status' => 'completed', 'notes' => 'Pembayaran lunas'],
            ['customer_name' => 'Ani Wijaya', 'user_id' => 2, 'sale_date' => now(), 'total_amount' => 320000, 'payment_method' => 'transfer', 'status' => 'pending', 'notes' => 'Menunggu konfirmasi']
        ] as $data) {
            Sale::create($data); 
        }
    }
}
