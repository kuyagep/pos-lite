<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    // POS Index (scanner + cart)
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('pos.index', compact('cart'));
    }

    // Add product by QR (AJAX)
    public function addToCart(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $product = Product::where('qr_code', $request->qr_code)->firstOrFail();

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['quantity'] * $cart[$product->id]['price'];
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    // Checkout
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $discount = $request->input('discount', 0);
        $customerName = $request->input('customer_name', null);

        DB::beginTransaction();
        try {
            $total = collect($cart)->sum(fn($item) => $item['subtotal']);
            $grandTotal = max($total - $discount, 0);

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => $grandTotal,
                'discount' => $discount,
                'payment_method' => 'cash', // extend later
                'notes' => $customerName,   // ✅ save notes/customer name
            ]);

            foreach ($cart as $productId => $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $product = Product::findOrFail($productId);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return response()->json(['message' => 'Sale completed!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Clear cart
    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('pos.index')->with('success', 'Cart cleared.');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
}
