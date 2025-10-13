<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School; // <-- THIS IS THE MISSING LINE
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::latest()->get();
        $schools = School::with('currentSubscription.plan')->latest()->get();
        // The 'activeMenus' variable is needed for the layout to work correctly
        $activeMenus = [1];
        return view('superadmin.schools.index', compact('schools', 'activeMenus'));
    }

    public function create()
    {
        // The 'activeMenus' variable is needed for the layout to work correctly
        $activeMenus = [1];
        return view('superadmin.schools.create', compact('activeMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        School::create($request->all());

        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'School created successfully.');
    }

    public function edit(School $school)
    {
        // The 'activeMenus' variable is needed for the layout to work correctly
        $activeMenus = [1];
        return view('superadmin.schools.edit', compact('school', 'activeMenus'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $school->update($request->all());

        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'School deleted successfully.');
    }
}
