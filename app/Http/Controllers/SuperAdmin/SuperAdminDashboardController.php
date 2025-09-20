<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $totalStores= 0;
        $totalOwners= 0;
        $totalCashiers= 0;
        $totalSales= 0;

        // $totalStores = Store::count();
        // $totalOwners = User::where('role', 'owner')->count();
        // $totalCashiers = User::where('role', 'cashier')->count();
        // $totalSales = Sale::sum('total_amount');

        return view('app.dashboard', compact(
            'totalStores',
            'totalOwners',
            'totalCashiers',
            'totalSales'
        ));
    }
}
