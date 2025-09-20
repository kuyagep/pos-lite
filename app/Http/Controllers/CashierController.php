<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    /**
     * Display a listing of the cashiers.
     */
    public function index()
    {
        // Show only users with role cashier
        $cashiers = User::where('role',  User::ROLE_STORE_STAFF)->get();

        return view('admin.cashiers.index', compact('cashiers'));
    }

    /**
     * Show the form for creating a new cashier.
     */
    public function create()
    {
        return view('admin.cashiers.create');
    }

    /**
     * Store a newly created cashier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $cashier = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => User::ROLE_STORE_STAFF,
            'created_by' => Auth::user()->id, // ✅ ULID of store admin/owner
        ]);

        return redirect()->route('cashiers.index', compact("cashier"))->with('success', 'Cashier added successfully!');
    }

    /**
     * Show the form for editing a cashier.
     */
    public function edit(User $cashier)
    {
        return view('admin.cashiers.edit', compact('cashier'));
    }

    /**
     * Update the specified cashier.
     */
    public function update(Request $request, User $cashier)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cashier->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $cashier->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $cashier->password,
        ]);

        return redirect()->route('cashiers.index')->with('success', 'Cashier updated successfully!');
    }

    /**
     * Remove the specified cashier.
     */
    public function destroy(User $cashier)
    {
        $cashier->delete();

        return redirect()->route('cashiers.index')->with('success', 'Cashier deleted successfully!');
    }
}
