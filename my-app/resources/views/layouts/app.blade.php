<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileButton = document.getElementById("user-menu-button");
        const profileDropdown = document.getElementById("profile-dropdown");

        profileButton.addEventListener("click", function () {
            profileDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add("hidden");
            }
        });
    });
</script>

    </head>
    <body class="antialiased font-sans">
        <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="lg:px-8 max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex h-16 justify-between items-center">
                <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-8" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="flex items-baseline ml-10 space-x-4">
                    <a href="#" class="bg-gray-900 rounded-md text-sm text-white font-medium px-3 py-2" aria-current="page">Dashboard</a>
                    <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Team</a>
                    <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Projects</a>
                    <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Calendar</a>
                    <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Reports</a>
                    </div>
                </div>
                </div>
                <div class="hidden md:block">
                <div class="flex items-center md:ml-6 ml-4">
                    <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white hover:text-white relative">
                    <span class="sr-only">View notifications</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    </button>
                    <div class="ml-3 relative">
                    <div>
                        <button type="button" class="flex bg-gray-800 rounded-full text-sm focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white items-center max-w-xs relative" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <img class="rounded-full size-8" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </button>
                    </div>
                    <div class="bg-white rounded-md shadow-lg w-48 absolute focus:outline-hidden mt-2 origin-top-right py-1 right-0 ring-1 ring-black/5 z-10 hidden" id="profile-dropdown" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href="#" class="text-gray-700 text-sm block px-4 py-2" role="menuitem">Your Profile</a>
                        <a href="/admin" class="text-gray-700 text-sm block px-4 py-2" role="menuitem">Admin</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 text-sm block w-full text-left px-4 py-2">
                                Sign out
                            </button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm">
            <div class="lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <h1 class="text-3xl text-gray-900 font-bold tracking-tight">Dashboard</h1>
            </div>
        </header>
        <main>
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Transaksi Anda</h1>

            <!-- Form Tambah Transaksi -->
            <div class="bg-white shadow-md p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold mb-3">Tambah Transaksi</h2>

                @if(session('success'))
                    <div class="bg-green-200 text-green-800 p-2 rounded mb-3">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="bg-red-200 text-red-800 p-2 rounded mb-3">{{ session('error') }}</div>
                @endif

                <form action="{{ route('cashier.sales.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-gray-700">Nama Pelanggan:</label>
                    <input type="text" name="customer_name" class="w-full border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700">Nomor HP:</label>
                    <input type="text" name="customer_phone" class="w-full border-gray-300 rounded p-2" required>
                </div>

                @isset($products)
                <div class="mb-3">
                    <label class="block text-gray-700">Produk:</label>
                    <select name="product_id" class="w-full border-gray-300 rounded p-2">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} (Stok: {{ $product->stock }}) - Rp{{ number_format($product->price, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endisset

                <div class="mb-3">
                    <label class="block text-gray-700">Jumlah:</label>
                    <input type="number" name="quantity" class="w-full border-gray-300 rounded p-2" min="1" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Transaksi</button>
            </form>

            </div>

            <!-- Riwayat Transaksi User -->
            <div class="bg-white shadow-md p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-3">Riwayat Transaksi Anda</h2>

    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Nomor</th>
                <th class="border p-2">Invoice</th>
                <th class="border p-2">Pelanggan</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Status</th>
            </tr>
        </thead>
        @isset($sales)
        <tbody>
            @foreach($sales as $index => $sale)
            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>
                <td class="border p-2">{{ $sale->invoice_number }}</td>
                <td class="border p-2">{{ $sale->customer_name }}</td>
                <td class="border p-2">{{ $sale->sale_date }}</td>
                <td class="border p-2">Rp{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                <td class="border p-2">
                    <span class="px-2 py-1 rounded text-white {{ $sale->status == 'completed' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $sale->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
        @endisset
    </table>
</div>

        </div>
        </main>

        </div>

    </body>
</html>
