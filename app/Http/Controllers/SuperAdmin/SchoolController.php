<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        // ** THIS IS THE UPDATED VALIDATION AND LOGIC **
        $validatedData = $request->validate([
            // School fields
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email', // Validate school email
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            // Admin user fields
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email', // Validate admin email separately
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 1. Create the School
        $school = School::create($validatedData);

        // 2. Create the School Superadmin User
        User::create([
            'name' => $validatedData['admin_name'],
            'email' => $validatedData['admin_email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'school_superadmin',
            'school_id' => $school->id,
        ]);

        return redirect()->route('superadmin.schools.index')
                         ->with('success', 'School and its admin account created successfully.');
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
