<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = User::where('role', User::ROLE_STORE_ADMIN)->get();
        return view('app.owners.index', compact('owners'));
    }

    public function create()
    {
        return view('app.owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|string|max:255',
            'store_phone' => 'required|string|max:255',
            'store_address' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request) {
            // Create owner
            $owner = User::create([
                'id' => Str::ulid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => User::ROLE_STORE_ADMIN,
            ]);

            // Create store & assign to owner
            Store::create([
                'id' => Str::ulid(),
                'name' => $request->store_name,
                'email' => $request->store_email,
                'phone' => $request->store_phone,
                'address' => $request->store_address,
                'owner_id' => $owner->id,
            ]);
        });

        return redirect()->route('app.owners.index')->with('success', 'Owner and Store created successfully.');
    }

    public function edit($id)
    {
        $owner = User::with('stores')->findOrFail($id);
        return view('app.owners.edit', compact('owner'));
    }

    public function update(Request $request, $id)
    {
        $owner = User::findOrFail($id);

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $owner->id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Update basic fields
        $owner->name = $validated['name'];
        $owner->email = $validated['email'];

        // Update password only if filled
        if (!empty($validated['password'])) {
            $owner->password = bcrypt($validated['password']);
        }

        $owner->save();

        return redirect()
            ->route('app.owners.index')
            ->with('success', 'Owner updated successfully!');
    }
}
