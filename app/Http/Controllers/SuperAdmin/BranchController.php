<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(School $school)
    {
        // ** THIS IS THE FIX **
        // Eager load the 'branches' relationship to ensure it's never null.
        $school->load('branches');

        $activeMenus = [1];
        return view('superadmin.branches.index', compact('school', 'activeMenus'));
    }

    public function create(School $school)
    {
        $activeMenus = [1];
        return view('superadmin.branches.create', compact('school', 'activeMenus'));
    }

    public function store(Request $request, School $school)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $school->branches()->create($validatedData);

        return redirect()->route('superadmin.schools.branches.index', $school)
                         ->with('success', 'Branch created successfully.');
    }

    public function edit(School $school, Branch $branch)
    {
        $activeMenus = [1];
        return view('superadmin.branches.edit', compact('school', 'branch', 'activeMenus'));
    }

    public function update(Request $request, School $school, Branch $branch)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $branch->update($validatedData);

        return redirect()->route('superadmin.schools.branches.index', $school)
                         ->with('success', 'Branch updated successfully.');
    }

    public function destroy(School $school, Branch $branch)
    {
        $branch->delete();

        return redirect()->route('superadmin.schools.branches.index', $school)
                         ->with('success', 'Branch deleted successfully.');
    }
}
