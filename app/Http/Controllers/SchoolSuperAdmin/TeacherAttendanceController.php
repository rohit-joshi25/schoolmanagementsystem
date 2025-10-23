<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\TeacherAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherAttendanceController extends Controller
{
    /**
     * Show the form to select branch/date and display the attendance sheet.
     */
    public function index(Request $request)
    {
        $activeMenus = [4]; // ID for Teachers menu
        $school = Auth::user()->school;
        $branches = $school->branches()->where('status', 'active')->get();

        $teachers = null;
        $attendanceRecords = null;
        $selectedData = [];

        // Check if the form has been submitted with all required fields
        if ($request->filled(['branch_id', 'attendance_date'])) {
            $validated = $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'attendance_date' => 'required|date',
            ]);

            $selectedData = $validated;

            // Fetch all teachers in the selected branch
            $teachers = User::where('role', 'teacher')
                            ->where('school_id', $school->id)
                            ->where('branch_id', $validated['branch_id'])
                            ->orderBy('full_name')
                            ->get();

            // Fetch existing attendance records for these teachers on this date
            $attendanceRecords = TeacherAttendance::where('branch_id', $validated['branch_id'])
                                                ->where('attendance_date', $validated['attendance_date'])
                                                ->pluck('status', 'user_id') // Get 'status' keyed by 'user_id'
                                                ->all();
        }

        return view('school-superadmin.teachers.attendance', compact(
            'branches', 
            'teachers', 
            'attendanceRecords', 
            'selectedData', 
            'activeMenus'
        ));
    }

    /**
     * Store the attendance data for the staff.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,half_day',
        ]);

        $branch = $school->branches()->findOrFail($validatedData['branch_id']);

        foreach ($validatedData['attendance'] as $teacherId => $status) {
            // Use updateOrCreate to add or update attendance for each teacher
            TeacherAttendance::updateOrCreate(
                [
                    'user_id' => $teacherId,
                    'attendance_date' => $validatedData['attendance_date']
                ],
                [
                    'school_id' => $school->id,
                    'branch_id' => $branch->id,
                    'status' => $status,
                    'notes' => $request->input("notes.{$teacherId}") ?? null,
                ]
            );
        }

        // Redirect back to the same page with the query parameters
        return redirect()->route('school-superadmin.teachers.attendance.index', [
            'branch_id' => $branch->id,
            'attendance_date' => $validatedData['attendance_date'],
        ])->with('success', 'Teacher attendance saved successfully.');
    }
}