<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\GradeSystem;
use App\Models\GradeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradeSystemController extends Controller
{
    /**
     * Display a listing of the grade systems.
     */
    public function index()
    {
        $activeMenus = [9]; // ID for Examinations menu
        $school = Auth::user()->school;
        $gradeSystems = $school->gradeSystems()->with('gradeDetails')->latest()->get();

        return view('school-superadmin.exams.grades.index', compact('gradeSystems', 'activeMenus'));
    }

    /**
     * Show the form for creating a new grade system.
     */
    public function create()
    {
        $activeMenus = [9];
        return view('school-superadmin.exams.grades.create', compact('activeMenus'));
    }

    /**
     * Store a newly created grade system and its details.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('grade_systems')->where('school_id', $school->id)],
            'description' => 'nullable|string',
            'grades' => 'required|array|min:1',
            'grades.*.grade_name' => 'required|string|max:50',
            'grades.*.mark_from' => 'required|numeric|min:0|max:100',
            'grades.*.mark_to' => 'required|numeric|min:0|max:100|gte:grades.*.mark_from',
            'grades.*.comments' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create the main Grade System
            $gradeSystem = $school->gradeSystems()->create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            // 2. Create all the Grade Details
            foreach ($validatedData['grades'] as $gradeDetail) {
                $gradeSystem->gradeDetails()->create($gradeDetail);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred. Please check your mark ranges.');
        }

        return redirect()->route('school-superadmin.grade-systems.index')
                         ->with('success', 'Grade System created successfully.');
    }

    /**
     * Show the form for editing the specified grade system.
     */
    public function edit(GradeSystem $gradeSystem)
    {
        // Security Check
        if ($gradeSystem->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [9];
        $gradeSystem->load('gradeDetails'); // Eager load the details

        return view('school-superadmin.exams.grades.edit', compact('gradeSystem', 'activeMenus'));
    }

    /**
     * Update the specified grade system and its details.
     */
    public function update(Request $request, GradeSystem $gradeSystem)
    {
        // Security Check
        if ($gradeSystem->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('grade_systems')->where('school_id', $school->id)->ignore($gradeSystem->id)],
            'description' => 'nullable|string',
            'grades' => 'required|array|min:1',
            'grades.*.grade_name' => 'required|string|max:50',
            'grades.*.mark_from' => 'required|numeric|min:0|max:100',
            'grades.*.mark_to' => 'required|numeric|min:0|max:100|gte:grades.*.mark_from',
            'grades.*.comments' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update the main Grade System
            $gradeSystem->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            // 2. Delete all old details
            $gradeSystem->gradeDetails()->delete();

            // 3. Create all the new Grade Details
            foreach ($validatedData['grades'] as $gradeDetail) {
                $gradeSystem->gradeDetails()->create($gradeDetail);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred. Please check your mark ranges.');
        }

        return redirect()->route('school-superadmin.grade-systems.index')
                         ->with('success', 'Grade System updated successfully.');
    }

    /**
     * Remove the specified grade system.
     */
    public function destroy(GradeSystem $gradeSystem)
    {
        // Security Check
        if ($gradeSystem->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        // The database cascade will delete all associated grade details
        $gradeSystem->delete();

        return redirect()->route('school-superadmin.grade-systems.index')
                         ->with('success', 'Grade System deleted successfully.');
    }
}
