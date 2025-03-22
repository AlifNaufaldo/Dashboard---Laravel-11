<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Product; 
use App\Models\Sale;

class UserController extends Controller {
    

    public function create()
    {
        return view('admin.users.create');
    }
    

    // Menyimpan user baru dengan role cashier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cashier',
        ]);

        return redirect()->route('admin.users.create')->with('success', 'Kasir berhasil ditambahkan!');
    }
}
