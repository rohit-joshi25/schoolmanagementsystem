<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();
        $activeMenus = [2];
        return view('superadmin.plans.index', compact('plans', 'activeMenus'));
    }

    public function create()
    {
        $activeMenus = [2];
        return view('superadmin.plans.create', compact('activeMenus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        Plan::create($validatedData);

        return redirect()->route('superadmin.plans.index')
                         ->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $activeMenus = [2];
        return view('superadmin.plans.edit', compact('plan', 'activeMenus'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $plan->update($validatedData);

        return redirect()->route('superadmin.plans.index')
                         ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('superadmin.plans.index')
                         ->with('success', 'Plan deleted successfully.');
    }
}
