<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    public function checkout()
    {
        return Inertia::render('Sales/Checkout', [
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        $discount = $data['discount'] ?? 0;
        $total = 0;

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'total_amount' => 0,
            'discount' => $discount,
            'payment_method' => $data['payment_method'],
        ]);

        foreach ($data['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $item['quantity'] * $product->price;
            $total += $subtotal;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock', $item['quantity']);
        }

        $sale->update(['total_amount' => $total - $discount]);

        return redirect()->route('sales.checkout')->with('success', 'Sale completed!');
    }
}
