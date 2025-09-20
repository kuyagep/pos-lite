<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();
        $owner = Auth::user();

        // ✅ Get all store IDs that belong to this owner
        $storeIds = $owner->stores()->pluck('id');

        // --- Daily Summary (Owner’s stores only) ---
        $todaySales = Sale::whereIn('store_id', $storeIds)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $todayTransactions = Sale::whereIn('store_id', $storeIds)
            ->whereDate('created_at', $today)
            ->count();

        $todayDiscounts = Sale::whereIn('store_id', $storeIds)
            ->whereDate('created_at', $today)
            ->sum('discount');

        // --- Sales Trend (Last 7 Days, Owner’s stores only) ---
        $last7Days = Sale::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->whereIn('store_id', $storeIds)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesDates = $last7Days->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
        $salesTotals = $last7Days->pluck('total')->toArray();

        // --- Payment Method Breakdown (today, Owner’s stores only) ---
        $payments = Sale::selectRaw('payment_method, COUNT(*) as count')
            ->whereIn('store_id', $storeIds)
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
