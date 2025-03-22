<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale; 

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        $sales = Sale::orderBy('sale_date', 'desc')->get(); 

        return view('cashier.index', compact('sales', 'products'));
    }
}