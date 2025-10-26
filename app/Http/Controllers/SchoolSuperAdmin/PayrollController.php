<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SalaryGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PayrollController extends Controller
{
    /**
     * Display the main payroll management page.
     * This page shows a list of all teachers and a form to manage salary grades.
     */
    public function index()
    {
        $activeMenus = [4]; // ID for Teachers menu
        $school = Auth::user()->school;

        // Get all teachers (and other staff)
        $staff = $school->users()
                        ->where('role', '!=', 'student')
                        ->where('role', '!=', 'school_superadmin')
                        ->with('salaryGrade')
                        ->orderBy('full_name')
                        ->get();
        
        // Get all salary grades for the school
        $salaryGrades = $school->salaryGrades()->orderBy('name')->get();

        return view('school-superadmin.teachers.payroll.index', compact(
            'staff', 
            'salaryGrades', 
            'activeMenus'
        ));
    }

    /**
     * Update a specific staff member's salary details.
     */
    public function update(Request $request, User $staff)
    {
        // Security Check: Ensure staff belongs to the school
        if ($staff->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'salary_grade_id' => ['nullable', 'exists:salary_grades,id', Rule::in($school->salaryGrades->pluck('id'))],
            'basic_salary' => 'nullable|numeric|min:0',
        ]);

        $staff->update($validatedData);

        return redirect()->route('school-superadmin.payroll.index')
                         ->with('success', 'Salary updated for ' . $staff->full_name . '.');
    }
}