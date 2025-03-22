<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'unit_price', 'subtotal'];

    /**
     * Setiap item penjualan dimiliki oleh satu transaksi.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Setiap item penjualan berisi satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
