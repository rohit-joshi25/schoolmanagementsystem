<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

class PerformanceCategoryController extends Controller
{
    /**
     * Store a newly created performance category.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('performance_categories')->where('school_id', $school->id)],
            'description' => 'nullable|string',
        ]);

        $school->performanceCategories()->create($validatedData);

        return redirect()->route('school-superadmin.performance.index')
                         ->with('success', 'Performance category created successfully.');
    }

    /**
     * Update the specified performance category.
     */
    public function update(Request $request, PerformanceCategory $performanceCategory)
    {
        // Security Check
        if ($performanceCategory->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('performance_categories')->where('school_id', $school->id)->ignore($performanceCategory->id)],
            'description' => 'nullable|string',
        ]);

        $performanceCategory->update($validatedData);

        return redirect()->route('school-superadmin.performance.index')
                         ->with('success', 'Performance category updated successfully.');
    }

    /**
     * Remove the specified performance category.
     */
    public function destroy(PerformanceCategory $performanceCategory)
    {
        // Security Check
        if ($performanceCategory->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $performanceCategory->delete();

        return redirect()->route('school-superadmin.performance.index')
                         ->with('success', 'Performance category deleted successfully.');
    }
}