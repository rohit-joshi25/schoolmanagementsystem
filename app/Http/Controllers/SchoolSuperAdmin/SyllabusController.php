<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the syllabi for the school.
     */
    public function index()
    {
        $activeMenus = [2]; // ID for Academics menu
        $school = Auth::user()->school;
        $syllabi = Syllabus::where('school_id', $school->id)
                           ->with('subject') // Eager load subject info
                           ->latest()
                           ->get();

        return view('school-superadmin.academics.syllabus.index', compact('syllabi', 'activeMenus'));
    }

    /**
     * Show the form for creating a new syllabus.
     */
    public function create()
    {
        $activeMenus = [2];
        $school = Auth::user()->school;
        $subjects = $school->subjects()->orderBy('name')->get(); // Get subjects for the dropdown

        return view('school-superadmin.academics.syllabus.create', compact('subjects', 'activeMenus'));
    }

    /**
     * Store a newly created syllabus in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id', Rule::in($school->subjects->pluck('id'))],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'syllabus_file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120', // Max 5MB file
        ]);

        $filePath = null;
        if ($request->hasFile('syllabus_file')) {
            $filePath = $request->file('syllabus_file')->store('syllabi/' . $school->id, 'public');
        }

        Syllabus::create([
            'school_id' => $school->id,
            'subject_id' => $validatedData['subject_id'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'file_path' => $filePath,
        ]);

        return redirect()->route('school-superadmin.syllabus.index')
                         ->with('success', 'Syllabus created successfully.');
    }

    /**
     * Remove the specified syllabus from storage.
     */
    public function destroy(Syllabus $syllabus)
    {
        // Security Check
        if ($syllabus->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        // Delete the associated file if it exists
        if ($syllabus->file_path) {
            Storage::disk('public')->delete($syllabus->file_path);
        }

        $syllabus->delete();

        return redirect()->route('school-superadmin.syllabus.index')
                         ->with('success', 'Syllabus deleted successfully.');
    }
}