<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    // List products for a specific store
    public function index(Store $store)
    {
        $this->authorizeStore($store);

        $products = $store->products()->latest()->get();
        return view('admin.products.index', compact('store', 'products'));
    }

    public function create(Store $store)
    {
        $this->authorizeStore($store);
        return view('admin.products.create', compact('store'));
    }

    private function generateUniqueQrCode()
    {
        do {
            // Generate a 7-digit random number
            $qrCode = random_int(1000000, 9999999);
        } while (\App\Models\Product::where('qr_code', $qrCode)->exists());

        return $qrCode;
    }

    public function store(Request $request, Store $store)
    {
        $this->authorizeStore($store);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:1',
        ]);
        $qrCodeValue = $this->generateUniqueQrCode(); // 10-digit numeric QR code // generate unique QR

        $store->products()->create([
            'name'            => $request->name,
            'category'        => $request->category,
            'price'           => $request->price,
            'stock'           => $request->stock,
            'low_stock_alert' => $request->low_stock_alert,
            'qr_code'         => $qrCodeValue, // ✅ explicitly add this field
        ]);

        return redirect()->route('stores.products.index', $store->id)
            ->with('success', 'Product added successfully.');
    }

    public function edit(Store $store, Product $product)
    {
        $this->authorizeStore($store);
        $this->authorizeStoreProduct($store, $product);

        return view('admin.products.edit', compact('store', 'product'));
    }

    public function update(Request $request, Store $store, Product $product)
    {
        $this->authorizeStore($store);
        $this->authorizeStoreProduct($store, $product);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:1',
        ]);

        $product->update($request->only('name', 'category', 'price', 'stock', 'low_stock_alert',));

        return redirect()->route('stores.products.index', $store->id)
            ->with('success', 'Product updated successfully.');
    }

    public function show(Store $store, Product $product)
    {
        // ✅ Ensure product belongs to this store (security check)
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.products.show', compact('store', 'product'));
    }

    public function destroy(Store $store, Product $product)
    {
        $this->authorizeStore($store);
        $this->authorizeStoreProduct($store, $product);

        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    // --- Authorization Helpers ---
    private function authorizeStore(Store $store)
    {
        if (!auth()->user()->stores->pluck('id')->contains($store->id)) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function authorizeStoreProduct(Store $store, Product $product)
    {
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized product.');
        }
    }
}
