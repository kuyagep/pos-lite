<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CashierDashboardController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\Owner\OwnerStoreController;
use App\Http\Controllers\Owner\StoreCashierController;
use App\Http\Controllers\Owner\StoreProductController;
use App\Http\Controllers\Owner\StoreSalesController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SuperAdmin\OwnerController;
use App\Http\Controllers\SuperAdmin\StoreController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Models\DailyReport;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/license/activate', [LicenseController::class, 'showActivateForm'])->name('license.activate');
Route::post('/license/activate/app', [LicenseController::class, 'activate'])->name('license.activate.submit');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         $products = Product::all();
//         $reports = DailyReport::latest()->take(5)->get();
//         return view('dashboard', compact('products', 'reports'));
//     })->name('dashboard');
// });


// Require active subscription for all products
Route::middleware(['auth', 'subscription'])->group(function () {
    // Route::resource('products', ProductController::class);
});

// Require active subscription + feature "reports"
// Route::get('/reports', [ReportController::class, 'index'])
//     ->middleware(['auth', 'subscription:reports']);


//!Super Admin routes
Route::middleware(['auth', 'role:' . User::ROLE_SUPER_ADMIN])->prefix('app')->name('app.')->group(function () {
    // Route::resource('plans', PlanController::class);
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('owners', OwnerController::class);
    Route::resource('stores', StoreController::class);
});

//? Store Admin routes
Route::middleware(['auth', 'role:' . User::ROLE_STORE_ADMIN, 'check.license'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/admin/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/stores', [OwnerStoreController::class, 'index'])->name('stores.index');

    // Multi-store Product Management
    Route::get('stores/{store}/products', [StoreProductController::class, 'index'])->name('stores.products.index');
    Route::get('stores/{store}/products/create', [StoreProductController::class, 'create'])->name('stores.products.create');
    Route::post('stores/{store}/products', [StoreProductController::class, 'store'])->name('stores.products.store');
    Route::get('stores/{store}/products/{product}/edit', [StoreProductController::class, 'edit'])->name('stores.products.edit');
    Route::put('stores/{store}/products/{product}', [StoreProductController::class, 'update'])->name('stores.products.update');
    Route::delete('stores/{store}/products/{product}', [StoreProductController::class, 'destroy'])->name('stores.products.destroy');
    Route::get('stores/{store}/products/{product}', [StoreProductController::class, 'show'])->name('stores.products.show');

    // Cashiers per store
    Route::get('/stores/{store}/cashiers', [StoreCashierController::class, 'index'])->name('stores.cashiers.index');
    Route::get('/stores/{store}/cashiers/create', [StoreCashierController::class, 'create'])->name('stores.cashiers.create');
    Route::post('/stores/{store}/cashiers', [StoreCashierController::class, 'store'])->name('stores.cashiers.store');
    Route::get('/stores/{store}/cashiers/{cashier}/edit', [StoreCashierController::class, 'edit'])->name('stores.cashiers.edit');
    Route::put('/stores/{store}/cashiers/{cashier}', [StoreCashierController::class, 'update'])->name('stores.cashiers.update');
    Route::delete('/stores/{store}/cashiers/{cashier}', [StoreCashierController::class, 'destroy'])->name('stores.cashiers.destroy');

    // Store Sales History
    Route::get('stores/{store}/sales', [\App\Http\Controllers\Owner\StoreSalesController::class, 'index'])->name('stores.sales.index');
    Route::get('/stores/{store}/sales/{sale}', [StoreSalesController::class, 'show'])->name('stores.sales.show');

});

//* Store Staff routes
Route::middleware(['auth', 'role:' . User::ROLE_STORE_STAFF, 'check.license'])->group(function () {
    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('cashier.dashboard');
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/add', [POSController::class, 'addToCart'])->name('pos.add');
    Route::get('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    Route::post('/pos/clear', [POSController::class, 'clearCart'])->name('pos.clear');
    Route::delete('/pos/remove', [POSController::class, 'removeFromCart'])->name('pos.remove');
    Route::post('/pos/confirm', [PosController::class, 'confirm'])->name('pos.confirm');
    Route::get('/pos/receipt/{id}', [PosController::class, 'receipt'])->name('pos.receipt');


    // Sales History
    Route::get('/sales-history', [SaleController::class, 'history'])->name('sales.history');
});

require __DIR__ . '/auth.php';
