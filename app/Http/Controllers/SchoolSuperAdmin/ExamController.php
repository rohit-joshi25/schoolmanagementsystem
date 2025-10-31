<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\GradeSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /**
     * Display a listing of the exams.
     */
    public function index()
    {
        $activeMenus = [9]; // ID for Examinations menu
        $school = Auth::user()->school;

        // Eager load the gradeSystem relationship
        $exams = $school->exams()->with('gradeSystem')->latest()->get();
        $gradeSystems = $school->gradeSystems()->orderBy('name')->get(); // For the create form

        return view('school-superadmin.exams.setup.index', compact('exams', 'gradeSystems', 'activeMenus'));
    }
    public function create()
    {
        $activeMenus = [9];
        $school = Auth::user()->school;
        $gradeSystems = $school->gradeSystems()->orderBy('name')->get();

        return view('school-superadmin.exams.setup.create', compact('gradeSystems', 'activeMenus'));
    }
    /**
     * Store a newly created exam in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('exams')->where('school_id', $school->id)],
            'grade_system_id' => ['required', 'exists:grade_systems,id', Rule::in($school->gradeSystems->pluck('id'))],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $school->exams()->create($validatedData);

        return redirect()->route('school-superadmin.exams.index')
                         ->with('success', 'Exam created successfully.');
    }

    /**
     * Show the form for editing the specified exam.
     */
    public function edit(Exam $exam)
    {
        // Security Check
        if ($exam->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [9];
        $school = Auth::user()->school;
        $gradeSystems = $school->gradeSystems()->orderBy('name')->get();

        return view('school-superadmin.exams.setup.edit', compact('exam', 'gradeSystems', 'activeMenus'));
    }

    /**
     * Update the specified exam in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        // Security Check
        if ($exam->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('exams')->where('school_id', $school->id)->ignore($exam->id)],
            'grade_system_id' => ['required', 'exists:grade_systems,id', Rule::in($school->gradeSystems->pluck('id'))],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exam->update($validatedData);

        return redirect()->route('school-superadmin.exams.index')
                         ->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified exam from storage.
     */
    public function destroy(Exam $exam)
    {
        // Security Check
        if ($exam->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $exam->delete();

        return redirect()->route('school-superadmin.exams.index')
                         ->with('success', 'Exam deleted successfully.');
    }
}
