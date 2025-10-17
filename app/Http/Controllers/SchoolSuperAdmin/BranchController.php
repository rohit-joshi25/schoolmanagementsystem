<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $activeMenus = [1];
        $school = Auth::user()->school;
        $branches = $school->branches()->latest()->get();

        return view('school-superadmin.branches.index', compact('school', 'branches', 'activeMenus'));
    }

    public function create()
    {
        $activeMenus = [1];
        return view('school-superadmin.branches.create', compact('activeMenus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $school = Auth::user()->school;
        $school->branches()->create($validatedData);

        return redirect()->route('school-superadmin.branches.index')
                         ->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        // Security Check: Make sure the branch belongs to the user's school
        if ($branch->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [1];

        // ** THIS IS THE FIX **
        // We must pass the $branch variable to the view so it can be used in the form.
        $activeMenus = [1];
    return view('school-superadmin.branches.edit', compact('branch', 'activeMenus')); // This is correct
}

    public function update(Request $request, Branch $branch)
    {
        // Security Check
        if ($branch->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $branch->update($validatedData);

        return redirect()->route('school-superadmin.branches.index')
                         ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        // Security Check
        if ($branch->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $branch->delete();

        return redirect()->route('school-superadmin.branches.index')
                         ->with('success', 'Branch deleted successfully.');
    }
     public function settings()
    {
        $activeMenus = [1];
        return view('school-superadmin.branches.settings', compact('activeMenus'));
    }
}
