<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignTeacherController extends Controller
{
    /**
     * Display a list of subjects and their assigned teachers.
     */
    public function index()
    {
        $activeMenus = [2]; 
        $school = Auth::user()->school;
        
        $subjects = $school->subjects()->with('teachers')->latest()->get();

        return view('school-superadmin.academics.assign-teachers.index', compact('subjects', 'activeMenus'));
    }

    /**
     * Show the form for editing teacher assignments for a specific subject.
     */
    public function edit(Subject $subject)
    {
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [2];
        $school = Auth::user()->school;
        
        // ** THIS IS THE FIX: Changed orderBy('name') to orderBy('full_name') **
        $teachers = $school->users()->where('role', 'teacher')->orderBy('full_name')->get();
        
        $assignedTeacherIds = $subject->teachers()->pluck('users.id')->toArray();

        return view('school-superadmin.academics.assign-teachers.edit', compact('subject', 'teachers', 'assignedTeacherIds', 'activeMenus'));
    }

    /**
     * Update the teacher assignments for a specific subject.
     */
    public function update(Request $request, Subject $subject)
    {
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:users,id',
        ]);
        
        $school = Auth::user()->school;
        $teacherIds = $validatedData['teachers'] ?? [];

        $validTeacherIds = $school->users()
                                  ->where('role', 'teacher')
                                  ->whereIn('id', $teacherIds)
                                  ->pluck('id')
                                  ->toArray();

        $subject->teachers()->sync($validTeacherIds);

        return redirect()->route('school-superadmin.assign-teachers.index')
                         ->with('success', 'Teacher assignments for ' . $subject->name . ' updated successfully.');
    }
}