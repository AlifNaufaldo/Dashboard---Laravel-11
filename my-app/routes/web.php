        <?php

        use App\Http\Controllers\ProfileController;
        use App\Http\Controllers\AuthController;
        use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
        use App\Http\Controllers\Admin\CategoryController;
        use App\Http\Controllers\Admin\ProductController;
        use App\Http\Controllers\Admin\CustomerController;
        use App\Http\Controllers\Admin\SaleController as AdminSaleController;
        use App\Http\Controllers\Admin\ReportController;
        use App\Http\Controllers\Admin\UserController;
        use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
        use App\Http\Controllers\Cashier\SaleController as CashierSaleController;
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Facades\Auth;

        // Halaman Utama
        Route::get('/', function () {
            return view('welcome');
        });

        // Redirect Dashboard sesuai role user
        Route::get('/dashboard', function () {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'cashier') {
                return redirect()->route('cashier.dashboard');
            }

            abort(403, 'Unauthorized');
        })->middleware('auth')->name('dashboard');

        // Grup route dengan middleware auth
        Route::middleware('auth')->group(function () {
            // 🔹 Profil User
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // 🔹 Logout
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

            // 🔹 Grup route untuk Admin
            Route::prefix('admin')
                ->middleware(['auth', 'role:admin'])
                ->name('admin.')
                ->group(function () {
                    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

                    // 📌 Master Data
                    Route::resource('/categories', CategoryController::class);
                    Route::resource('/products', ProductController::class);
                    Route::resource('/customers', CustomerController::class);

                    // 📌 Transaksi Penjualan 
                    Route::resource('/sales', AdminSaleController::class)->except(['create', 'store']);
                    Route::get('/sales/{id}', [AdminSaleController::class, 'show'])->name('sales.show'); 
                    Route::get('/sales/{id}/edit', [AdminSaleController::class, 'edit'])->name('sales.edit'); 
                    Route::put('/sales/{id}', [AdminSaleController::class, 'update'])->name('sales.update'); 
                    Route::delete('/sales/{id}', [AdminSaleController::class, 'destroy'])->name('sales.destroy'); 

                    // 📌 Laporan Penjualan
                    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

                    // 📌 Manajemen User 
                    Route::resource('/users', UserController::class)->only(['create', 'store']);

                });

            // 🔹 Grup route untuk Kasir
            Route::prefix('cashier')
                ->middleware(['auth', 'role:cashier'])
                ->name('cashier.')
                ->group(function () {
                    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
                    Route::get('/sales', [CashierSaleController::class, 'index'])->name('sales.index');
                    Route::post('/sales', [CashierSaleController::class, 'store'])->name('sales.store');
                });
        });

        require __DIR__.'/auth.php';
