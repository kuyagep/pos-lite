<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreSalesController extends Controller
{
    /**
     * Show sales history for a store with filters.
     */
    public function index(Store $store, Request $request)
    {
        $this->authorizeStore($store);

        $filter = $request->input('filter', 'today');
        $query = Sale::where('store_id', $store->id);

        if ($filter === 'today') {
            $query->whereDate('created_at', today());
            $from = today()->toDateString();
            $to   = today()->toDateString();
        } elseif ($filter === 'week') {
            $query->where('created_at', '>=', now()->startOfWeek());
            $from = now()->startOfWeek()->toDateString();
            $to   = now()->endOfWeek()->toDateString();
        } else {
            $from = $request->input('from', now()->subMonth()->toDateString());
            $to   = $request->input('to', now()->toDateString());
            $query->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()]);
        }

        $sales = $query->latest()->paginate(15);

        return view('admin.sales.index', compact('store', 'sales', 'filter', 'from', 'to'));
    }

    public function show(Store $store, Sale $sale)
    {
        $this->authorizeStore($store);

        // Make sure sale belongs to the store
        if ($sale->store_id !== $store->id) {
            abort(403, 'Unauthorized access to this sale.');
        }

        $sale->load('items.product', 'store'); // eager load relationships

        return view('admin.sales.show', compact('store', 'sale'));
    }


    /**
     * Ensure logged-in Owner/Admin can only access their own store.
     */
    protected function authorizeStore(Store $store)
    {
        $user = auth()->user();

        // Super admin bypass
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            return true;
        }

        // Owner/Admin must own this store
        if ($store->owner_id !== $user->id) {
            abort(403, 'Unauthorized access to this store.');
        }
    }
}
