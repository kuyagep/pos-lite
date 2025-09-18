<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Models\DailyReport;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

});

Route::middleware(['auth'])->group(function () {

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
