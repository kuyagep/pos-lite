<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DailyReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index', [
            'reports' => DailyReport::with('bestProduct')->latest('report_date')->get(),
        ]);
    }

    public function generate()
    {
        $date = now()->toDateString();

        $sales = Sale::whereDate('created_at', $date)->with('items')->get();

        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();

        $bestProduct = SaleItem::whereHas('sale', function ($q) use ($date) {
            $q->whereDate('created_at', $date);
        })
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->first();

        DailyReport::updateOrCreate(
            ['report_date' => $date],
            [
                'total_sales' => $totalSales,
                'total_transactions' => $totalTransactions,
                'best_selling_product' => $bestProduct?->product_id,
            ]
        );

        return redirect()->route('reports.index')->with('success', 'Report generated!');
    }
}
