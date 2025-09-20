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
        $qrCodeValue = uniqid();
        $store->products()->create($request->only('name', 'category', 'price', 'stock', 'low_stock_alert', $qrCodeValue));

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
