<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Section;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $activeMenus = [3];
        $school = Auth::user()->school;
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();

        $students = null;
        $attendanceRecords = null;
        $selectedData = [];

        if ($request->filled(['branch_id', 'academic_class_id', 'section_id', 'attendance_date'])) {
            $validated = $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'academic_class_id' => 'required|exists:academic_classes,id',
                'section_id' => 'required|exists:sections,id',
                'attendance_date' => 'required|date',
            ]);

            $selectedData = $validated;

            // ** THIS IS THE FIX: Changed orderBy('name') to orderBy('full_name') **
            $students = User::where('role', 'student')
                            ->where('school_id', $school->id)
                            ->where('branch_id', $validated['branch_id'])
                            ->where('academic_class_id', $validated['academic_class_id'])
                            ->where('section_id', $validated['section_id'])
                            ->orderBy('full_name') // <-- THE FIX IS HERE
                            ->get();

            $attendanceRecords = StudentAttendance::where('section_id', $validated['section_id'])
                                                ->where('attendance_date', $validated['attendance_date'])
                                                ->pluck('status', 'user_id')
                                                ->all();
        }

        return view('school-superadmin.academics.students.attendance', compact(
            'branches', 
            'students', 
            'attendanceRecords', 
            'selectedData', 
            'activeMenus'
        ));
    }
    /**
     * Store the attendance data for the section.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,half_day', // The possible statuses
        ]);

        $section = Section::with('academicClass')->findOrFail($validatedData['section_id']);

        // Security Check
        if ($section->academicClass->school_id !== $school->id) {
            abort(403, 'This section does not belong to your school.');
        }

        foreach ($validatedData['attendance'] as $studentId => $status) {
            // Use updateOrCreate to add or update attendance for each student
            StudentAttendance::updateOrCreate(
                [
                    'user_id' => $studentId,
                    'attendance_date' => $validatedData['attendance_date']
                ],
                [
                    'school_id' => $school->id,
                    'branch_id' => $section->academicClass->branch_id,
                    'academic_class_id' => $section->academic_class_id,
                    'section_id' => $section->id,
                    'status' => $status,
                    'notes' => $request->input("notes.{$studentId}") ?? null,
                ]
            );
        }

        // Redirect back to the same page with the query parameters
        return redirect()->route('school-superadmin.students.attendance.index', [
            'branch_id' => $section->academicClass->branch_id,
            'academic_class_id' => $section->academic_class_id,
            'section_id' => $section->id,
            'attendance_date' => $validatedData['attendance_date'],
        ])->with('success', 'Attendance saved successfully.');
    }
}