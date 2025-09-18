<?php

use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Models\DailyReport;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {

});

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('reports', [DailyReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [DailyReportController::class, 'generate'])->name('reports.generate');

    // cashier routes
    Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('pos/add', [PosController::class, 'addToCart'])->name('pos.add');
    Route::post('pos/remove', [PosController::class, 'removeFromCart'])->name('pos.remove');
    Route::post('pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
});


// Require active subscription for all products
Route::middleware(['auth', 'subscription'])->group(function () {
    // Route::resource('products', ProductController::class);
});

// Require active subscription + feature "reports"
// Route::get('/reports', [ReportController::class, 'index'])
//     ->middleware(['auth', 'subscription:reports']);


// Super Admin routes
// Route::middleware(['auth', 'role:' . User::ROLE_SUPER_ADMIN])->group(function () {
//     Route::resource('plans', PlanController::class);
// });

// Store Admin routes
// Route::middleware(['auth', 'role:' . User::ROLE_STORE_ADMIN])->group(function () {
//     Route::resource('products', ProductController::class);
//     Route::get('reports', [ReportController::class, 'index']);
// });

// Staff routes
// Route::middleware(['auth', 'role:' . User::ROLE_STAFF])->group(function () {
//     Route::post('sales', [SaleController::class, 'store']);
// });

require __DIR__ . '/auth.php';
