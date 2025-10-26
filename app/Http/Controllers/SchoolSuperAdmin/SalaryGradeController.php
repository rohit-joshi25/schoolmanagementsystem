<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SalaryGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SalaryGradeController extends Controller
{
    // Note: We won't use index/create/edit pages, 
    // as we'll manage this on the main payroll page.

    /**
     * Store a newly created salary grade.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('salary_grades')->where('school_id', $school->id)],
            'description' => 'nullable|string',
        ]);

        $school->salaryGrades()->create($validatedData);

        return redirect()->route('school-superadmin.payroll.index')
                         ->with('success', 'Salary Grade created successfully.');
    }

    /**
     * Update the specified salary grade.
     */
    public function update(Request $request, SalaryGrade $salaryGrade)
    {
        // Security Check
        if ($salaryGrade->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('salary_grades')->where('school_id', $school->id)->ignore($salaryGrade->id)],
            'description' => 'nullable|string',
        ]);

        $salaryGrade->update($validatedData);

        return redirect()->route('school-superadmin.payroll.index')
                         ->with('success', 'Salary Grade updated successfully.');
    }

    /**
     * Remove the specified salary grade.
     */
    public function destroy(SalaryGrade $salaryGrade)
    {
        // Security Check
        if ($salaryGrade->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        // Note: The database will set user's salary_grade_id to null
        $salaryGrade->delete();

        return redirect()->route('school-superadmin.payroll.index')
                         ->with('success', 'Salary Grade deleted successfully.');
    }
}