<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreCashierController extends Controller
{
    public function index(Store $store)
    {
        $cashiers = $store->cashiers; // assuming Store hasMany Cashiers
        return view('admin.cashiers.index', compact('store', 'cashiers'));
    }

    public function create(Store $store)
    {
        return view('admin.cashiers.create', compact('store'));
    }

    public function store(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);



        $cashier = User::create([
            'store_id' => $store->id,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => User::ROLE_STORE_STAFF,
        ]);

        // dd($cashier);
        return redirect()->route('stores.cashiers.index', $store->id)->with('success', 'Cashier added.');
    }

    public function edit(Store $store, User $cashier)
    {
        return view('admin.cashiers.edit', compact('store', 'cashier'));
    }

    public function update(Request $request, Store $store, User $cashier)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $cashier->id,
        ]);

        $cashier->update($request->only('name', 'email'));

        if ($request->filled('password')) {
            $cashier->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('stores.cashiers.index', $store->id)->with('success', 'Cashier updated.');
    }

    public function destroy(Store $store, User $cashier)
    {
        $cashier->delete();
        return redirect()->route('stores.cashiers.index', $store->id)->with('success', 'Cashier deleted.');
    }
}
