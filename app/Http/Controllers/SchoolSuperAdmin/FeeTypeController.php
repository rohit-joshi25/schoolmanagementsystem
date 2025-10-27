<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use App\Models\FeeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeeTypeController extends Controller
{
    /**
     * Display a listing of the fee types.
     */
    public function index()
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school;
        
        // Eager load the feeGroup relationship
        $feeTypes = $school->feeTypes()->with('feeGroup')->latest()->get();

        return view('school-superadmin.fees.types.index', compact('feeTypes', 'activeMenus'));
    }

    /**
     * Show the form for creating a new fee type.
     */
    public function create()
    {
        $activeMenus = [6];
        $school = Auth::user()->school;
        $feeGroups = $school->feeGroups()->orderBy('name')->get();

        return view('school-superadmin.fees.types.create', compact('feeGroups', 'activeMenus'));
    }

    /**
     * Store a newly created fee type.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fee_group_id' => ['required', 'exists:fee_groups,id', Rule::in($school->feeGroups->pluck('id'))],
            'fee_code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $school->feeTypes()->create($validatedData);

        return redirect()->route('school-superadmin.fee-types.index')
                         ->with('success', 'Fee Type created successfully.');
    }

    /**
     * Show the form for editing the specified fee type.
     */
    public function edit(FeeType $feeType)
    {
        // Security Check
        if ($feeType->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [6];
        $school = Auth::user()->school;
        $feeGroups = $school->feeGroups()->orderBy('name')->get();

        return view('school-superadmin.fees.types.edit', compact('feeType', 'feeGroups', 'activeMenus'));
    }

    /**
     * Update the specified fee type.
     */
    public function update(Request $request, FeeType $feeType)
    {
        // Security Check
        if ($feeType->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fee_group_id' => ['required', 'exists:fee_groups,id', Rule::in($school->feeGroups->pluck('id'))],
            'fee_code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $feeType->update($validatedData);

        return redirect()->route('school-superadmin.fee-types.index')
                         ->with('success', 'Fee Type updated successfully.');
    }

    /**
     * Remove the specified fee type.
     */
    public function destroy(FeeType $feeType)
    {
        // Security Check
        if ($feeType->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $feeType->delete();

        return redirect()->route('school-superadmin.fee-types.index')
                         ->with('success', 'Fee Type deleted successfully.');
    }
}