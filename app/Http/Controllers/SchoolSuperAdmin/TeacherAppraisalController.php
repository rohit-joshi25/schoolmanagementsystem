<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeacherAppraisal;
use App\Models\PerformanceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherAppraisalController extends Controller
{
    /**
     * Display a listing of past appraisals.
     */
    public function index()
    {
        $activeMenus = [4]; // ID for Teachers menu
        $school = Auth::user()->school;

        // Eager load teacher and appraiser relationships
        $appraisals = $school->teacherAppraisals()
                             ->with(['teacher', 'appraiser'])
                             ->latest()
                             ->get();
        
        $categories = $school->performanceCategories()->orderBy('name')->get();

        return view('school-superadmin.teachers.performance.index', compact(
            'appraisals', 
            'categories', 
            'activeMenus'
        ));
    }

    /**
     * Show the form for creating a new appraisal.
     */
    public function create()
    {
        $activeMenus = [4];
        $school = Auth::user()->school;

        $teachers = $school->users()->where('role', 'teacher')->orderBy('full_name')->get();
        $categories = $school->performanceCategories()->orderBy('name')->get();

        return view('school-superadmin.teachers.performance.create', compact(
            'teachers', 
            'categories', 
            'activeMenus'
        ));
    }

    /**
     * Store a new appraisal in the database.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'teacher_id' => ['required', 'exists:users,id', Rule::in($school->users()->where('role', 'teacher')->pluck('id'))],
            'appraisal_date' => 'required|date',
            'overall_comments' => 'nullable|string',
            'ratings' => 'required|array',
            'ratings.*.rating' => 'required|integer|min:1|max:5',
            'ratings.*.comments' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $appraisal = TeacherAppraisal::create([
                'school_id' => $school->id,
                'teacher_id' => $validatedData['teacher_id'],
                'appraiser_id' => Auth::id(),
                'appraisal_date' => $validatedData['appraisal_date'],
                'overall_comments' => $validatedData['overall_comments'],
            ]);

            foreach ($validatedData['ratings'] as $categoryId => $ratingData) {
                $appraisal->ratings()->create([
                    'performance_category_id' => $categoryId,
                    'rating' => $ratingData['rating'],
                    'comments' => $ratingData['comments'],
                ]);
            }

            DB::commit(); 

        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'An error occurred while saving the appraisal. Please try again. ' . $e->getMessage());
        }

        return redirect()->route('school-superadmin.performance.index')
                         ->with('success', 'Teacher performance appraisal saved successfully.');
    }

    /**
     * ** NEW METHOD TO SHOW A SINGLE APPRAISAL **
     * Display the specified appraisal.
     */
    public function show(TeacherAppraisal $performance)
    {
        // Use $performance to match the route resource name
        $appraisal = $performance;

        // Security Check
        if ($appraisal->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        // Eager load all relationships for the view
        $appraisal->load(['teacher', 'appraiser', 'ratings.category']);

        $activeMenus = [4];
        return view('school-superadmin.teachers.performance.show', compact('appraisal', 'activeMenus'));
    }
}