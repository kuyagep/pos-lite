<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        return Inertia::render('Plans/Index', [
            'plans' => $plans
        ]);
    }

    public function create()
    {
        return Inertia::render('Plans/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        Plan::create([
            'name'          => $request->name,
            'price'         => $request->price,
            'duration_days' => $request->duration_days,
            'features'      => $request->features ?? [],
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan)
    {
        return Inertia::render('Plans/Edit', [
            'plan' => $plan
        ]);
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        $plan->update([
            'name'          => $request->name,
            'price'         => $request->price,
            'duration_days' => $request->duration_days,
            'features'      => $request->features ?? [],
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plan deleted.');
    }
}
