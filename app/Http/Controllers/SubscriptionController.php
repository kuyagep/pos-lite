<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        $expiresAt = Carbon::now()->addDays($plan->duration_days);

        Subscription::create([
            'user_id'    => auth()->id(),
            'plan_id'    => $plan->id,
            'expires_at' => $expiresAt,
            'active'     => true,
        ]);

        return back()->with('success', 'Subscription activated.');
    }
}
