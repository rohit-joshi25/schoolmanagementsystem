<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AcademicClassController extends Controller
{
    public function index()
    {
        $activeMenus = [2];
        $school = Auth::user()->school;
        $classes = $school->classes()->with('sections', 'branch')->latest()->get();

        return view('school-superadmin.academics.classes.index', compact('classes', 'activeMenus'));
    }

    public function create()
    {
        $activeMenus = [2];
        $branches = Auth::user()->school->branches()->where('status', 'active')->get();
        return view('school-superadmin.academics.classes.create', compact('branches', 'activeMenus'));
    }

    public function store(Request $request)
    {
        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'name' => 'required|string|max:255',
            'sections' => 'required|array|min:1',
            'sections.*' => 'required|string|max:255',
        ]);

        $class = AcademicClass::create([
            'school_id' => $school->id,
            'branch_id' => $validatedData['branch_id'],
            'name' => $validatedData['name'],
        ]);

        foreach ($validatedData['sections'] as $sectionName) {
            $class->sections()->create(['name' => $sectionName]);
        }

        return redirect()->route('school-superadmin.classes.index')
                         ->with('success', 'Class and sections created successfully.');
    }

    public function destroy(AcademicClass $class)
    {
        if ($class->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        $class->delete();
        return redirect()->route('school-superadmin.classes.index')
                         ->with('success', 'Class deleted successfully.');
    }
}