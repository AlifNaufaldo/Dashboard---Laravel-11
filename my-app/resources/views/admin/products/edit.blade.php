@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $product->name }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">{{ $product->description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-semibold mb-2">Harga</label>
            <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $product->price }}" required>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok</label>
            <input type="number" name="stock" id="stock" class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $product->stock }}" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">Update</button>
    </form>
</div>
@endsection
