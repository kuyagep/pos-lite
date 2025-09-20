<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerStoreController extends Controller
{
    public function index()
    {
        $stores = auth()->user()->stores; // assuming a user->stores() relationship

        return view('admin.stores.index', compact('stores'));
    }
}
