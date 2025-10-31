<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Section;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\User;
use App\Models\ExamMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MarksEntryController extends Controller
{
    /**
     * Show the form to select class/exam/subject and display the marks entry sheet.
     */
    public function index(Request $request)
    {
        $activeMenus = [9]; // ID for Examinations menu
        $school = Auth::user()->school;

        // Data for dropdowns
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        $exams = $school->exams()->get();
        $subjects = $school->subjects()->get();

        $students = null;
        $existingMarks = null;
        $selected = [];

        // If the form has been submitted to search for students
        if ($request->filled(['exam_id', 'branch_id', 'academic_class_id', 'section_id', 'subject_id'])) {
            $validated = $request->validate([
                'exam_id' => 'required|exists:exams,id',
                'branch_id' => 'required|exists:branches,id',
                'academic_class_id' => 'required|exists:academic_classes,id',
                'section_id' => 'required|exists:sections,id',
                'subject_id' => 'required|exists:subjects,id',
            ]);

            $selected = $validated;

            // Fetch all students in the selected section
            $students = User::where('role', 'student')
                            ->where('school_id', $school->id)
                            ->where('branch_id', $validated['branch_id'])
                            ->where('academic_class_id', $validated['academic_class_id'])
                            ->where('section_id', $validated['section_id'])
                            ->orderBy('full_name')
                            ->get();

            // Fetch existing marks for this specific exam/subject/section
            $existingMarks = ExamMark::where('exam_id', $validated['exam_id'])
                                     ->where('subject_id', $validated['subject_id'])
                                     ->where('section_id', $validated['section_id'])
                                     ->pluck('marks_obtained', 'student_id') // Get 'marks_obtained' keyed by 'student_id'
                                     ->all();
        }

        return view('school-superadmin.exams.marks-entry.index', compact(
            'branches',
            'exams',
            'subjects',
            'students',
            'existingMarks',
            'selected',
            'activeMenus'
        ));
    }

    /**
     * Store or Update the marks for the entire section.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'branch_id' => 'required|exists:branches,id',
            'academic_class_id' => 'required|exists:academic_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*.marks_obtained' => 'required|numeric|min:0',
            'marks.*.total_marks' => 'required|numeric|min:0',
            'marks.*.comments' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validatedData['marks'] as $studentId => $markData) {
                // Use updateOrCreate to add or update marks for each student
                ExamMark::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'exam_id' => $validatedData['exam_id'],
                        'subject_id' => $validatedData['subject_id'],
                        'student_id' => $studentId,
                    ],
                    [
                        'branch_id' => $validatedData['branch_id'],
                        'academic_class_id' => $validatedData['academic_class_id'],
                        'section_id' => $validatedData['section_id'],
                        'marks_obtained' => $markData['marks_obtained'],
                        'total_marks' => $markData['total_marks'],
                        'comments' => $markData['comments'] ?? null,
                    ]
                );
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while saving marks. Please try again.');
        }

        // Redirect back to the same search page
        return redirect()->route('school-superadmin.marks-entry.index', [
            'exam_id' => $validatedData['exam_id'],
            'branch_id' => $validatedData['branch_id'],
            'academic_class_id' => $validatedData['academic_class_id'],
            'section_id' => $validatedData['section_id'],
            'subject_id' => $validatedData['subject_id'],
        ])->with('success', 'Marks saved successfully.');
    }
}
