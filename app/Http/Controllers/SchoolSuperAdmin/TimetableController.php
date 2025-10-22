<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TimetableController extends Controller
{
    /**
     * Show form to select class and section for timetable view/management.
     */
    public function index()
    {
        $activeMenus = [2]; 
        $school = Auth::user()->school;
        $branches = $school->branches()->with(['classes.sections'])->get();

        return view('school-superadmin.academics.timetable.index', compact('branches', 'activeMenus'));
    }

    /**
     * Display the timetable for a specific section.
     */
    public function show(Section $section)
    {
        $activeMenus = [2];
        $school = Auth::user()->school;

        if ($section->academicClass->school_id !== $school->id) {
            abort(403);
        }

        $timetableEntries = Timetable::where('section_id', $section->id)
                                    ->with(['subject', 'teacher'])
                                    ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                                    ->orderBy('start_time')
                                    ->get()
                                    ->groupBy('day_of_week');

        // ** THIS IS THE FIX: Changed orderBy('name') to orderBy('full_name') **
        $teachers = $school->users()->where('role', 'teacher')->orderBy('full_name')->get();
        $subjects = $school->subjects()->orderBy('name')->get();
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];


        return view('school-superadmin.academics.timetable.show', compact(
            'section', 
            'timetableEntries', 
            'teachers', 
            'subjects', 
            'daysOfWeek',
            'activeMenus'
        ));
    }

    /**
     * Store a new timetable entry.
     */
    public function store(Request $request, Section $section)
    {
        if ($section->academicClass->school_id !== Auth::user()->school_id) {
             abort(403);
        }
        
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id', Rule::in($school->subjects->pluck('id'))],
            'teacher_id' => ['required', 'exists:users,id', Rule::in($school->users()->where('role', 'teacher')->pluck('id'))],
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Timetable::create([
            'school_id' => $school->id,
            'branch_id' => $section->academicClass->branch_id,
            'academic_class_id' => $section->academic_class_id,
            'section_id' => $section->id,
            'subject_id' => $validatedData['subject_id'],
            'teacher_id' => $validatedData['teacher_id'],
            'day_of_week' => $validatedData['day_of_week'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        return redirect()->route('school-superadmin.timetable.show', $section)
                         ->with('success', 'Timetable entry added successfully.');
    }


    /**
     * Delete a timetable entry.
     */
    public function destroy(Timetable $timetable)
    {
        if ($timetable->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $section = $timetable->section;
        $timetable->delete();

        return redirect()->route('school-superadmin.timetable.show', $section)
                         ->with('success', 'Timetable entry deleted successfully.');
    }
}