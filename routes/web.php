<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\CashierDashboardController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
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


//Super Admin routes
Route::middleware(['auth', 'role:' . User::ROLE_SUPER_ADMIN])->prefix('app')->name('app.')->group(function () {
    // Route::resource('plans', PlanController::class);
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('owners', OwnerController::class);
    Route::resource('stores', StoreController::class);
});

// Store Admin routes
Route::middleware(['auth', 'role:' . User::ROLE_STORE_ADMIN])->group(function () {
    Route::get('/admin', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('cashiers', CashierController::class);
    Route::resource('products', ProductController::class);
    Route::get('/sales/summary', [SaleController::class, 'summary'])->name('sales.summary');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('reports', [DailyReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [DailyReportController::class, 'generate'])->name('reports.generate');
});

// Store Staff routes
Route::middleware(['auth', 'role:' . User::ROLE_STORE_STAFF])->group(function () {
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
