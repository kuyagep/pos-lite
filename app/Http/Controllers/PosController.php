<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    // Add product to cart
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->qr_code);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    // Remove product from cart
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    // Checkout
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'discount' => $request->discount ?? 0,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($cart as $productId => $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Deduct stock
            $product = Product::find($productId);
            $product->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');
        return redirect()->route('sales.index')->with('success', 'Sale completed!');
    }
}
