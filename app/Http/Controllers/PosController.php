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
    /**
     * Show POS main page with cart + products
     */
    public function index()
    {
        $cashier = Auth::user();
        $store   = $cashier->store;
        $products = $store->products()->where('stock', '>', 0)->get();

        $cart = Session::get('cart', []);

        return view('pos.index', compact('cart', 'products'));
    }

    /**
     * Add product by QR (AJAX request)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $product = Product::where('qr_code', $request->qr_code)
            ->where('stock', '>', 0)
            ->firstOrFail();

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            // Prevent overselling
            if ($cart[$product->id]['quantity'] >= $product->stock) {
                return response()->json([
                    'error' => 'Not enough stock available for ' . $product->name
                ], 422);
            }

            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
            ];
        }

        $cart[$product->id]['subtotal'] = $cart[$product->id]['quantity'] * $cart[$product->id]['price'];

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart'    => $cart
        ]);
    }

    /**
     * Checkout Page
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        $subtotal   = collect($cart)->sum(fn($item) => $item['subtotal']);
        $totalItems = collect($cart)->sum(fn($item) => $item['quantity']);

        return view('pos.checkout', compact('cart', 'subtotal', 'totalItems'));
    }

    /**
     * Confirm and save transaction
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:cash,card,e-wallet',
            'discount'       => 'nullable|numeric|min:0',
            'customer_name'  => 'nullable|string|max:255',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();
        try {
            $cashier = $request->user();
            $store   = $cashier->store;

            $discount   = $request->input('discount', 0);
            $total      = collect($cart)->sum(fn($item) => $item['subtotal']);
            $grandTotal = max($total - $discount, 0);

            // Save Sale
            $sale = Sale::create([
                'store_id'       => $store->id,
                'user_id'     => $cashier->id,
                'total_amount'   => $grandTotal,
                'discount'       => $discount,
                'payment_method' => $request->payment_method,
                'notes'          => $request->customer_name,
            ]);

            // Save Items
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);

                // Double-check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                ]);

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            Session::forget('cart');

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully!',
                'sale_id' => $sale->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Transaction failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Receipt Page
     */
    public function receipt($id)
    {
        $store = auth()->user()->store;
        $sale = Sale::with(['items.product', 'cashier'])->find($id);

        if (!$sale) {
            return redirect()->route('pos.index')->with('error', 'Receipt not found.');
        }

        return view('pos.receipt', compact('sale','store'));
    }

    /**
     * Remove one product from cart
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart'    => $cart
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('pos.index')->with('success', 'Cart cleared.');
    }
}
