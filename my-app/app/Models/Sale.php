<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_id',
        'user_id',
        'invoice_number',
        'sale_date',
        'total_amount',
        'payment_method',
        'status',
        'notes',
        'npwp'
    ];

    /**
     * Setiap transaksi dimiliki oleh satu user (kasir).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Setiap transaksi memiliki banyak item penjualan.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Setiap transaksi berhubungan dengan satu customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Generate invoice_number yang unik.
     */
    public static function generateInvoiceNumber()
    {
        do {
            $invoiceNumber = 'INV-' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        } while (self::where('invoice_number', $invoiceNumber)->exists());
    
        return $invoiceNumber;
    }
}
