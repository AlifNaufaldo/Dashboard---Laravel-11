@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>    
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pengguna -->
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-3xl font-bold">{{ isset($totalUsers) ? $totalUsers : '0' }}</h3>
            <p class="text-lg">Total Pengguna</p>
        </div>

        <!-- Total Produk -->
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-3xl font-bold">{{ isset($totalProducts) ? $totalProducts : '0' }}</h3>
            <p class="text-lg">Total Produk</p>
        </div>

        <!-- Total Penjualan -->
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-3xl font-bold">
                Rp {{ isset($totalSales) ? number_format($totalSales, 0, ',', '.') : '0' }}
            </h3>
            <p class="text-lg">Total Penjualan</p>
        </div>

        <!-- Total Pelanggan -->
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-3xl font-bold">{{ isset($totalCustomers) ? $totalCustomers : '0' }}</h3>
            <p class="text-lg">Total Pelanggan</p>
        </div>
    </div>
</div>
@endsection
