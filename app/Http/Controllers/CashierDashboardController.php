<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class CashierDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalSalesToday = Sale::where('user_id', auth()->id())->whereDate('created_at', $today)->sum('total_amount');
        $transactionCountToday = Sale::where('user_id', auth()->id())->whereDate('created_at', $today)->count();

        return view('cashier.dashboard', compact(
            'totalSalesToday',
            'transactionCountToday',
            'today'
        ));
    }
}
