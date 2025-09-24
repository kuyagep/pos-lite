<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('owner')->latest()->paginate(10);
        return view('app.stores.index', compact('stores'));
    }

    public function create(Request $request)
    {
        // Get owner_id from query string
        $ownerId = $request->query('owner_id');


        if ($ownerId) {
            $owner = User::findOrFail($ownerId);
        }

        return view('app.stores.create', compact('owner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:stores,email',
            'phone'  => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'owner_id' => 'required|exists:users,id',
        ]);

        Store::create($request->all());

        return redirect()->route('app.stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        $owners = User::where('role', User::ROLE_STORE_ADMIN)->get();
        return view('app.stores.edit', compact('store', 'owners'));
    }

    public function update(Request $request, Store $store)
    {
        // dd($request->all());
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:stores,email,' . $store->id,
            'phone'  => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'owner_id' => 'required|exists:users,id',
        ]);
            // dd($request->all());
        $store->update($request->all());

        return redirect()->route('app.stores.index')->with('success', 'Store updated successfully.');
    }

    public function show($id)
    {
        $store = Store::with('owner')->findOrFail($id);

        return view('app.stores.show', compact('store'));
    }


    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('app.stores.index')->with('success', 'Store deleted successfully.');
    }
}
