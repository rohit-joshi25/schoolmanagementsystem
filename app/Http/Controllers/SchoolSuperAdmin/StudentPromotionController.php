<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AcademicClass;
use App\Models\Branch;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentPromotionController extends Controller
{
    /**
     * Show the student promotion form and search results.
     */
    public function index(Request $request)
    {
        $activeMenus = [3]; // ID for Students menu
        $school = Auth::user()->school;
        
        // Get all branches with their classes and sections for the dropdowns
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        
        $students = null;
        
        // If the form has been submitted to search for students
        if ($request->filled('from_section_id')) {
            $request->validate([
                'from_branch_id' => 'required|exists:branches,id',
                'from_class_id' => 'required|exists:academic_classes,id',
                'from_section_id' => 'required|exists:sections,id',
            ]);

            $students = User::where('role', 'student')
                            ->where('school_id', $school->id)
                            ->where('branch_id', $request->from_branch_id)
                            ->where('academic_class_id', $request->from_class_id)
                            ->where('section_id', $request->from_section_id)
                            ->get();
        }

        return view('school-superadmin.academics.students.promotion', compact(
            'branches', 
            'students', 
            'activeMenus'
        ));
    }

    /**
     * Promote the selected students to a new class/section.
     */
    public function promote(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
            'to_branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'to_class_id' => ['required', 'exists:academic_classes,id'],
            'to_section_id' => ['required', 'exists:sections,id'],
        ]);
        
        // Security Check: Ensure all students belong to this school
        $studentsToPromote = User::where('school_id', $school->id)
                                 ->whereIn('id', $validatedData['student_ids'])
                                 ->get();
        
        if (count($validatedData['student_ids']) !== $studentsToPromote->count()) {
            return back()->with('error', 'An invalid student was selected.');
        }

        // Perform the bulk update (Promotion)
        User::whereIn('id', $validatedData['student_ids'])
            ->update([
                'branch_id' => $validatedData['to_branch_id'],
                'academic_class_id' => $validatedData['to_class_id'],
                'section_id' => $validatedData['to_section_id'],
            ]);

        return redirect()->route('school-superadmin.students.promotion.index')
                         ->with('success', count($validatedData['student_ids']) . ' students were promoted successfully.');
    }
}