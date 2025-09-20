<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('cashier')->latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        $total = 0;
        foreach ($data['products'] as $item) {
            $product = Product::find($item['id']);
            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;
        }

        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $total - ($data['discount'] ?? 0),
            'discount' => $data['discount'] ?? 0,
            'payment_method' => $data['payment_method'],
        ]);

        foreach ($data['products'] as $item) {
            $product = Product::find($item['id']);
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'cashier');
        return view('admin.sales.show', compact('sale'));
    }

    public function history(Request $request)
    {
        $query = Sale::where('user_id', auth()->id());

        if ($request->filter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($request->filter === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }
        // else 'all' → no extra filter

        $sales = $query->latest()->paginate(10);

        return view('cashier.sales.history', compact('sales'));
    }
}
