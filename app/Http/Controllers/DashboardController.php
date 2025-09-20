<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        // --- Daily Summary (variables match Blade: todaySales, todayTransactions, todayDiscounts) ---
        $todaySales = Sale::whereDate('created_at', $today)->sum('total_amount');
        $todayTransactions = Sale::whereDate('created_at', $today)->count();
        $todayDiscounts = Sale::whereDate('created_at', $today)->sum('discount');

        // --- Sales Trend (Last 7 Days) ---
        $last7Days = Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format labels and totals for Chart.js
        $salesDates = $last7Days->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
        $salesTotals = $last7Days->pluck('total')->toArray();

        // --- Payment Method Breakdown (today) ---
        $payments = Sale::selectRaw('payment_method, COUNT(*) as count')
            ->whereDate('created_at', $today)
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method');

        $paymentMethods = $payments->keys()->toArray();
        $paymentCounts = $payments->values()->toArray();

        return view('admin.dashboard', compact(
            'todaySales',
            'todayTransactions',
            'todayDiscounts',
            'salesDates',
            'salesTotals',
            'paymentMethods',
            'paymentCounts',
            'today'
        ));
    }
}
