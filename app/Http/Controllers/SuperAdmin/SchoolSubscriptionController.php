<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Plan;
use App\Models\SchoolSubscription;
use Illuminate\Http\Request;

class SchoolSubscriptionController extends Controller
{
    /**
     * Show the form for assigning a plan to a school.
     */
    public function create()
    {
        $activeMenus = [2];

        // ** THIS IS THE UPDATED QUERY **
        // Get all active schools that DO NOT HAVE an active subscription.
        $schools = School::where('status', 'active')
                         ->doesntHave('currentSubscription')
                         ->get();

        $plans = Plan::where('status', 'active')->get();

        return view('superadmin.subscriptions.create', compact('schools', 'plans', 'activeMenus'));
    }

    /**
     * Store a new subscription in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'required|date',
        ]);

        $plan = Plan::findOrFail($validatedData['plan_id']);
        $startDate = new \DateTime($validatedData['start_date']);
        $endDate = clone $startDate;

        if (stripos($plan->duration, 'Yearly') !== false) {
            $endDate->modify('+1 year');
        } elseif (stripos($plan->duration, 'Monthly') !== false) {
            $endDate->modify('+1 month');
        } else {
            $endDate->modify('+1 year');
        }

        // We no longer need to cancel old plans, as this page only shows schools without one.
        // However, it's good practice to leave this for edge cases.
        SchoolSubscription::where('school_id', $validatedData['school_id'])
                            ->where('status', 'active')
                            ->update(['status' => 'cancelled']);

        SchoolSubscription::create([
            'school_id' => $validatedData['school_id'],
            'plan_id' => $validatedData['plan_id'],
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => 'active',
        ]);

        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'Plan assigned to the school successfully.');
    }
}
