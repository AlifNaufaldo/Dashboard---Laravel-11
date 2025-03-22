<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-200 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white p-5 flex flex-col justify-between">
        <nav class="flex flex-col space-y-2">
            <a href="/admin/dashboard">
                    <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
                </a>
            <a href="{{ route('admin.products.index') }}" class="block py-2 px-4 rounded-md transition duration-200 hover:bg-blue-700">
                📦 Produk
            </a>
            <a href="{{ route('admin.sales.index') }}" class="block py-2 px-4 rounded-md transition duration-200 hover:bg-blue-700">
                💰 Transaksi
            </a>
            <a href="{{ route('admin.users.create') }}" class="block py-2 px-4 rounded-md transition duration-200 hover:bg-blue-700">
                👤 Kelola Kasir 
            </a>
        </nav>


        <!-- Bagian Nama User dan Logout -->
        <div class="mt-6 border-t border-blue-700 pt-4">
            <p class="text-center text-sm">Login sebagai: <br> <span class="font-bold">{{ auth()->user()->name }}</span></p>
            <form action="{{ route('logout') }}" method="POST" class="mt-2 text-center">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
