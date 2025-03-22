<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalSales = Sale::sum('total_amount');
        $totalCustomers = Customer::count();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalSales', 'totalCustomers'));
    }
}
