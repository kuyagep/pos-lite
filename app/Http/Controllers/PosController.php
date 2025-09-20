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
    public function checkout()
    {
        $cart = session()->get('cart', []);

        // Calculate totals
        $subtotal = collect($cart)->sum(fn($item) => $item['subtotal']);
        $totalItems = collect($cart)->sum(fn($item) => $item['quantity']);

        return view('pos.checkout', [
            'cart'       => $cart,
            'subtotal'   => $subtotal,
            'totalItems' => $totalItems,
        ]);
    }


    // Confirm Payment
    public function confirm(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $discount = $request->input('discount', 0);
        $customerName = $request->input('customer_name', null);
        $paymentMethod = $request->input('payment_method', 'cash'); // ✅ dynamic payment method

        DB::beginTransaction();
        try {
            // Calculate totals
            $total = collect($cart)->sum(fn($item) => $item['subtotal']);
            $grandTotal = max($total - $discount, 0);

            // Create Sale record
            $sale = Sale::create([
                'store_id' => $request->user()->store_id, // assign the logged-in user's store
                'user_id'        => auth()->id(),
                'total_amount'   => $grandTotal,
                'discount'       => $discount,
                'payment_method' => $paymentMethod,
                'notes'          => $customerName, // ✅ Save customer name/notes
            ]);

            // Save Sale Items + Update Stock
            foreach ($cart as $productId => $item) {
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                ]);

                // Decrement stock
                $product = Product::findOrFail($productId);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart after success
            Session::forget('cart');

            return response()->json([
                'message' => 'Sale completed!',
                'sale_id' => $sale->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Receipt Page
    public function receipt($id)
    {
        // ✅ Fetch from DB (instead of session) for persistence
        $transaction = Sale::with('items.product') // assuming you have TransactionItem model
            ->find($id);

        if (!$transaction) {
            return redirect()->route('pos.index')
                ->with('error', 'Receipt not found!');
        }

        return view('pos.receipt', compact('transaction'));
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
