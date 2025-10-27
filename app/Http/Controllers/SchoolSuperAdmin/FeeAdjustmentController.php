<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FeeAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeeAdjustmentController extends Controller
{
    /**
     * Display a listing of the fee adjustments (Discounts/Fines).
     */
    public function index()
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school;
        
        $discounts = $school->feeAdjustments()->where('type', 'discount')->latest()->get();
        $fines = $school->feeAdjustments()->where('type', 'fine')->latest()->get();

        return view('school-superadmin.fees.discounts-fines.index', compact('discounts', 'fines', 'activeMenus'));
    }

    /**
     * Store a newly created fee adjustment.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('fee_adjustments')->where('school_id', $school->id)],
            'type' => 'required|in:discount,fine',
            'amount' => 'required|numeric|min:0',
            'is_percentage' => 'nullable|boolean',
        ]);
        
        // Ensure the boolean value is set correctly from the checkbox
        $validatedData['is_percentage'] = $request->has('is_percentage');

        $school->feeAdjustments()->create($validatedData);

        return redirect()->route('school-superadmin.fee-adjustments.index')
                         ->with('success', ucfirst($validatedData['type']) . ' created successfully.');
    }

    /**
     * Update the specified fee adjustment.
     */
    public function update(Request $request, FeeAdjustment $feeAdjustment)
    {
        // Security Check
        if ($feeAdjustment->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('fee_adjustments')->where('school_id', $school->id)->ignore($feeAdjustment->id)],
            'type' => 'required|in:discount,fine',
            'amount' => 'required|numeric|min:0',
            'is_percentage' => 'nullable|boolean',
        ]);

        $validatedData['is_percentage'] = $request->has('is_percentage');

        $feeAdjustment->update($validatedData);

        return redirect()->route('school-superadmin.fee-adjustments.index')
                         ->with('success', ucfirst($validatedData['type']) . ' updated successfully.');
    }

    /**
     * Remove the specified fee adjustment.
     */
    public function destroy(FeeAdjustment $feeAdjustment)
    {
        // Security Check
        if ($feeAdjustment->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $feeAdjustment->delete();

        return redirect()->route('school-superadmin.fee-adjustments.index')
                         ->with('success', 'Fee adjustment deleted successfully.');
    }
}