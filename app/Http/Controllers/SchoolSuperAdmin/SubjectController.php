<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index()
    {
        $activeMenus = [2]; // ID for Academics menu
        $school = Auth::user()->school;
        $subjects = $school->subjects()->latest()->get();

        return view('school-superadmin.academics.subjects.index', compact('subjects', 'activeMenus'));
    }

    public function create()
    {
        $activeMenus = [2];
        return view('school-superadmin.academics.subjects.create', compact('activeMenus'));
    }

    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subjects')->where('school_id', $school->id)],
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:Theory,Practical',
        ]);

        $school->subjects()->create($validatedData);

        return redirect()->route('school-superadmin.subjects.index')
                         ->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        // Security Check: Ensure the subject belongs to the user's school
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [2];
        return view('school-superadmin.academics.subjects.edit', compact('subject', 'activeMenus'));
    }

    public function update(Request $request, Subject $subject)
    {
        // Security Check
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subjects')->where('school_id', $school->id)->ignore($subject->id)],
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:Theory,Practical',
        ]);

        $subject->update($validatedData);

        return redirect()->route('school-superadmin.subjects.index')
                         ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        // Security Check
        if ($subject->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        
        $subject->delete();

        return redirect()->route('school-superadmin.subjects.index')
                         ->with('success', 'Subject deleted successfully.');
    }
}