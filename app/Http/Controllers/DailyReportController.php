<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DailyReportController extends Controller
{
    public function index()
    {
        $reports = DailyReport::latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function generate(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();

        $sales = Sale::whereDate('created_at', $date)->get();
        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();

        $bestSelling = SaleItem::selectRaw('product_id, SUM(quantity) as total_qty')
            ->whereHas('sale', function ($q) use ($date) {
                $q->whereDate('created_at', $date);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->first();

        $bestSellingProduct = $bestSelling ? Product::find($bestSelling->product_id)->name : null;

        $report = DailyReport::updateOrCreate(
            ['report_date' => $date],
            [
                'total_sales' => $totalSales,
                'total_transactions' => $totalTransactions,
                'best_selling_product' => $bestSellingProduct,
            ]
        );

        return redirect()->route('reports.index')->with('success', 'Report generated successfully!');
    }
}
