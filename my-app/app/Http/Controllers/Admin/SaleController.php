<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;

class SaleController extends Controller
{
    /**
     * Menampilkan semua transaksi penjualan (untuk Admin).
     */
    public function index()
    {
        $sales = Sale::with(['saleItems.product', 'user', 'customer'])->get();
        return view('admin.sales.index', compact('sales'));
    }
    

    /**
     * Menampilkan detail transaksi tertentu.
     */
    public function show($id)
    {
        $sale = Sale::with(['user', 'customer'])->find($id);

        if (!$sale) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($sale);
    }
    

    /**
     * Mengedit transaksi penjualan.
     */
    public function edit($id)
    {
        $sale = Sale::with('user', 'customer') 
        ->findOrFail($id);
    
        return response()->json($sale);
    }

    /**
     * Memperbarui transaksi penjualan.
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui',
                'sale' => $sale
            ]);
        }
        
        return redirect()->route('admin.sales.index')->with('success', 'Transaksi berhasil diperbarui');
    }
    // menghapus transaksi
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return redirect()->route('admin.sales.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        $sale->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Transaksi berhasil dihapus.');
    }
    

}
