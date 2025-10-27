<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeeAllocation;
use App\Models\FeeType;
use App\Models\AcademicClass;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeeAllocationController extends Controller
{
    /**
     * Display a listing of the fee allocations.
     */
    public function index()
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school;
        
        // Eager load relationships for efficiency
        $allocations = $school->feeAllocations()
                              ->with(['academicClass', 'feeType', 'branch'])
                              ->latest()
                              ->get();

        return view('school-superadmin.fees.allocations.index', compact('allocations', 'activeMenus'));
    }

    /**
     * Show the form for creating a new fee allocation.
     */
    public function create()
    {
        $activeMenus = [6];
        $school = Auth::user()->school;
        
        $branches = $school->branches()->with('classes')->where('status', 'active')->get();
        $feeTypes = $school->feeTypes()->orderBy('name')->get();

        return view('school-superadmin.fees.allocations.create', compact('branches', 'feeTypes', 'activeMenus'));
    }

    /**
     * Store a newly created fee allocation.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'fee_type_id' => ['required', 'exists:fee_types,id', Rule::in($school->feeTypes->pluck('id'))],
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $school->feeAllocations()->create($validatedData);

        return redirect()->route('school-superadmin.fee-allocations.index')
                         ->with('success', 'Fee allocated successfully.');
    }

    /**
     * Show the form for editing the specified fee allocation.
     */
    public function edit(FeeAllocation $feeAllocation)
    {
        // Security Check
        if ($feeAllocation->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [6];
        $school = Auth::user()->school;
        
        $branches = $school->branches()->with('classes')->where('status', 'active')->get();
        $feeTypes = $school->feeTypes()->orderBy('name')->get();

        return view('school-superadmin.fees.allocations.edit', compact('feeAllocation', 'branches', 'feeTypes', 'activeMenus'));
    }

    /**
     * Update the specified fee allocation.
     */
    public function update(Request $request, FeeAllocation $feeAllocation)
    {
        // Security Check
        if ($feeAllocation->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'fee_type_id' => ['required', 'exists:fee_types,id', Rule::in($school->feeTypes->pluck('id'))],
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $feeAllocation->update($validatedData);

        return redirect()->route('school-superadmin.fee-allocations.index')
                         ->with('success', 'Fee allocation updated successfully.');
    }

    /**
     * Remove the specified fee allocation.
     */
    public function destroy(FeeAllocation $feeAllocation)
    {
        // Security Check
        if ($feeAllocation->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $feeAllocation->delete();

        return redirect()->route('school-superadmin.fee-allocations.index')
                         ->with('success', 'Fee allocation deleted successfully.');
    }
}