<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class SaleController extends Controller
{
    /**
     * Menampilkan transaksi hanya untuk kasir yang login.
     */
    public function index()
    {
        $sales = Sale::where('user_id', Auth::id())->with('saleItems.product')->get();
        $products = Product::where('stock', '>', 0)->get();

        return view('cashier.sales.index', compact('sales', 'products'));
    }

    /**
     * Menambahkan transaksi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50',
            'customer_phone' => 'required|string|min:10|max:15|regex:/^\d+$/',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $product = Product::where('id', $request->product_id)->lockForUpdate()->firstOrFail();

                if ($product->stock < $request->quantity) {
                    return back()->with('error', 'Stok tidak mencukupi.');
                }

                // Cari atau buat customer berdasarkan nama dan nomor telepon
                $customer = Customer::firstOrCreate([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);

                // Gunakan fungsi dari Model untuk generate nomor invoice
                $newInvoiceNumber = Sale::generateInvoiceNumber();

                // Simpan transaksi
                $sale = Sale::create([
                    'customer_name' => $customer->name,
                    'customer_id' => $customer->id,
                    'user_id' => Auth::id(),
                    'sale_date' => now(),
                    'total_amount' => $product->price * $request->quantity,
                    'payment_method' => 'cash',
                    'status' => 'completed',
                    'notes' => 'Pembelian berhasil',
                    'invoice_number' => $newInvoiceNumber,
                ]);

                // Simpan item transaksi
                $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $request->quantity,
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $request->quantity);

                return back()->with('success', 'Transaksi berhasil ditambahkan!');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
