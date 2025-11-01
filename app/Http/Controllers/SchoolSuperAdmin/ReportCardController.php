<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Exam;
use App\Models\Section;
use App\Models\User;
use App\Models\ExamMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportCardController extends Controller
{
    /**
     * Show the form to select a student for generating a report card.
     */
    public function index(Request $request)
    {
        $activeMenus = [9]; // ID for Examinations menu
        $school = Auth::user()->school;
        
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        $exams = $school->exams()->get();
        
        $students = null;
        $selected = $request->only(['branch_id', 'academic_class_id', 'section_id', 'exam_id']);

        if ($request->filled(['branch_id', 'academic_class_id', 'section_id', 'exam_id'])) {
            $students = User::where('role', 'student')
                            ->where('school_id', $school->id)
                            ->where('section_id', $request->section_id)
                            ->orderBy('full_name')
                            ->get();
        }

        return view('school-superadmin.exams.report-cards.index', compact(
            'branches', 
            'exams',
            'students',
            'selected',
            'activeMenus'
        ));
    }

    /**
     * Generate and display the report card for a specific student and exam.
     */
    public function show(Request $request)
    {
        $activeMenus = [9];
        $school = Auth::user()->school;

        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::with(['branch', 'academicClass', 'section'])
                       ->where('id', $validated['student_id'])
                       ->where('school_id', $school->id)
                       ->firstOrFail();
        
        $exam = Exam::with('gradeSystem.gradeDetails')->findOrFail($validated['exam_id']);
        
        $marks = ExamMark::where('student_id', $student->id)
                         ->where('exam_id', $exam->id)
                         ->with('subject')
                         ->get();

        $totalMarksObtained = $marks->sum('marks_obtained');
        $totalMaxMarks = $marks->sum('total_marks');
        $percentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;
        
        // Find the overall grade from the grade system
        $overallGrade = $this->getGradeFromMarks($exam->gradeSystem->gradeDetails, $percentage);

        // Add grade to each subject mark
        $marksWithGrades = $marks->map(function ($mark) use ($exam) {
            $subjectPercentage = ($mark->total_marks > 0) ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
            $mark->grade = $this->getGradeFromMarks($exam->gradeSystem->gradeDetails, $subjectPercentage);
            return $mark;
        });

        return view('school-superadmin.exams.report-cards.show', compact(
            'student',
            'exam',
            'marksWithGrades',
            'totalMarksObtained',
            'totalMaxMarks',
            'percentage',
            'overallGrade',
            'activeMenus'
        ));
    }

    /**
     * Helper function to find the matching grade for a percentage.
     */
    private function getGradeFromMarks($gradeDetails, $percentage)
    {
        foreach ($gradeDetails as $detail) {
            if ($percentage >= $detail->mark_from && $percentage <= $detail->mark_to) {
                return $detail;
            }
        }
        return null; // No grade found
    }
}