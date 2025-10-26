<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeeGroupController extends Controller
{
    /**
     * Display a listing of the fee groups.
     */
    public function index()
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school; 
        $feeGroups = $school->feeGroups()->latest()->get();

        return view('school-superadmin.fees.groups.index', compact('feeGroups', 'activeMenus'));
    }

    /**
     * Show the form for creating a new fee group.
     */
    public function create()
    {
        $activeMenus = [6];
        return view('school-superadmin.fees.groups.create', compact('activeMenus'));
    }

    /**
     * Store a newly created fee group.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('fee_groups')->where('school_id', $school->id)],
            'description' => 'nullable|string',
        ]);

        $school->feeGroups()->create($validatedData);

        return redirect()->route('school-superadmin.fee-groups.index')
                         ->with('success', 'Fee Group created successfully.');
    }

    /**
     * Show the form for editing the specified fee group.
     */
    public function edit(FeeGroup $feeGroup)
    {
        // Security Check
        if ($feeGroup->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        $activeMenus = [6];
        return view('school-superadmin.fees.groups.edit', compact('feeGroup', 'activeMenus'));
    }

    /**
     * Update the specified fee group.
     */
    public function update(Request $request, FeeGroup $feeGroup)
    {
        // Security Check
        if ($feeGroup->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('fee_groups')->where('school_id', $school->id)->ignore($feeGroup->id)],
            'description' => 'nullable|string',
        ]);

        $feeGroup->update($validatedData);

        return redirect()->route('school-superadmin.fee-groups.index')
                         ->with('success', 'Fee Group updated successfully.');
    }

    /**
     * Remove the specified fee group.
     */
    public function destroy(FeeGroup $feeGroup)
    {
        // Security Check
        if ($feeGroup->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $feeGroup->delete();

        return redirect()->route('school-superadmin.fee-groups.index')
                         ->with('success', 'Fee Group deleted successfully.');
    }
}