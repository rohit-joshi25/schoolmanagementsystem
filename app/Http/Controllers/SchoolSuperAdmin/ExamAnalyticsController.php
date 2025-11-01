<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamAnalyticsController extends Controller
{
    /**
     * Show the form to select criteria and display the analytics report.
     */
    public function index(Request $request)
    {
        $activeMenus = [9]; // ID for Examinations menu
        $school = Auth::user()->school;

        // Data for dropdowns
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        $exams = $school->exams()->with('gradeSystem.gradeDetails')->get(); // Load grade systems

        $studentResults = null;
        $stats = null;
        $selected = $request->only(['branch_id', 'academic_class_id', 'section_id', 'exam_id']);

        // If the form has been submitted to search
        if ($request->filled(['branch_id', 'academic_class_id', 'section_id', 'exam_id'])) {
            
            $exam = $exams->find($selected['exam_id']);
            
            // Find the pass mark from the exam's grade system
            // We'll assume the lowest "mark_from" is the passing threshold
            $passMark = $exam->gradeSystem->gradeDetails->min('mark_from') ?? 40; // Default to 40 if no grades
            
            // Get all students in the selected section
            $students = User::where('role', 'student')
                            ->where('section_id', $selected['section_id'])
                            ->orderBy('full_name')
                            ->get();
            
            // Get all marks for this exam and section, grouped by student
            $allMarks = $school->examMarks()
                               ->where('exam_id', $selected['exam_id'])
                               ->where('section_id', $selected['section_id'])
                               ->get()
                               ->groupBy('student_id');

            $studentResults = [];
            $passCount = 0;
            $failCount = 0;

            foreach ($students as $student) {
                $studentMarks = $allMarks->get($student->id);

                if ($studentMarks) {
                    $totalObtained = $studentMarks->sum('marks_obtained');
                    $totalMax = $studentMarks->sum('total_marks');
                    $percentage = ($totalMax > 0) ? ($totalObtained / $totalMax) * 100 : 0;
                    
                    $status = ($percentage >= $passMark) ? 'Pass' : 'Fail';
                    if ($status == 'Pass') {
                        $passCount++;
                    } else {
                        $failCount++;
                    }

                    $studentResults[] = [
                        'student' => $student,
                        'total_obtained' => $totalObtained,
                        'total_max' => $totalMax,
                        'percentage' => $percentage,
                        'status' => $status,
                    ];
                }
            }

            $totalStudents = count($studentResults);
            $stats = [
                'pass_count' => $passCount,
                'fail_count' => $failCount,
                'total_students' => $totalStudents,
                'pass_percentage' => ($totalStudents > 0) ? ($passCount / $totalStudents) * 100 : 0,
            ];
        }

        return view('school-superadmin.exams.analytics.index', compact(
            'branches', 
            'exams', 
            'selected', 
            'studentResults', 
            'stats',
            'activeMenus'
        ));
    }
}