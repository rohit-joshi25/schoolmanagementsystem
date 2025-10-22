<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\AcademicClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a list of students, filterable by branch and class.
     */
    public function index(Request $request)
    {
        $activeMenus = [3];
        $school = Auth::user()->school;

        $query = $school->users()->where('role', 'student');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('class_id')) {
            $query->where('academic_class_id', $request->class_id);
        }

        // ** FIXED: Order by 'full_name' instead of 'name' **
        $students = $query->with(['branch', 'academicClass', 'section'])->latest('full_name')->get();
        $branches = $school->branches()->with('classes')->get();

        return view('school-superadmin.academics.students.index', compact('students', 'branches', 'activeMenus'));
    }

    /**
     * Show the student admission form.
     */
    public function create()
    {
        $activeMenus = [3];
        $school = Auth::user()->school;
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        
        $categories = ['General', 'OBC', 'SC', 'ST', 'Other'];
        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $houses = ['Blue', 'Red', 'Green', 'Yellow'];

        return view('school-superadmin.academics.students.create', compact('branches', 'categories', 'blood_groups', 'houses', 'activeMenus'));
    }

    /**
     * Store a new student (Admission).
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            // Academic
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            // Student
            'admission_no' => 'required|string|max:50',
            'roll_number' => 'nullable|string|max:50',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'category' => 'nullable|string',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'admission_date' => 'required|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blood_group' => 'nullable|string',
            'house' => 'nullable|string',
            'height' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'measurement_date' => 'nullable|date',
            'medical_history' => 'nullable|string',
            // Login
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // Guardian
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relation' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('student_photo')) {
            $photoPath = $request->file('student_photo')->store('student_photos/' . $school->id, 'public');
        }
        
        $fullName = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

        User::create(array_merge($validatedData, [
            'school_id' => $school->id,
            'full_name' => $fullName,
            'password' => Hash::make($validatedData['password']),
            'role' => 'student',
            'student_photo_path' => $photoPath,
        ]));

        return redirect()->route('school-superadmin.students.index')
                         ->with('success', 'Student admitted successfully.');
    }

    // ** NEW EDIT METHOD **
    public function edit(User $student)
    {
        // Security Check
        if ($student->school_id !== Auth::user()->school_id || $student->role !== 'student') {
            abort(403);
        }

        $activeMenus = [3];
        $school = Auth::user()->school;
        $branches = $school->branches()->with(['classes.sections'])->where('status', 'active')->get();
        
        $categories = ['General', 'OBC', 'SC', 'ST', 'Other'];
        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $houses = ['Blue', 'Red', 'Green', 'Yellow'];

        return view('school-superadmin.academics.students.edit', compact(
            'student', 'branches', 'categories', 'blood_groups', 'houses', 'activeMenus'
        ));
    }

    // ** NEW UPDATE METHOD **
    public function update(Request $request, User $student)
    {
        // Security Check
        if ($student->school_id !== Auth::user()->school_id || $student->role !== 'student') {
            abort(403);
        }
        
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            // Academic
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'academic_class_id' => ['required', 'exists:academic_classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            // Student
            'admission_no' => 'required|string|max:50',
            'roll_number' => 'nullable|string|max:50',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'category' => 'nullable|string',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'admission_date' => 'required|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blood_group' => 'nullable|string',
            'house' => 'nullable|string',
            'height' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'measurement_date' => 'nullable|date',
            'medical_history' => 'nullable|string',
            // Login (Password is optional)
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            // Guardian
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relation' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
        ]);

        $dataToUpdate = $validatedData;

        // Handle file upload
        if ($request->hasFile('student_photo')) {
            // Delete old photo
            if ($student->student_photo_path) {
                Storage::disk('public')->delete($student->student_photo_path);
            }
            $dataToUpdate['student_photo_path'] = $request->file('student_photo')->store('student_photos/' . $school->id, 'public');
        }
        
        // Combine first and last name
        $dataToUpdate['full_name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        
        // Handle password update
        if (!empty($validatedData['password'])) {
            $dataToUpdate['password'] = Hash::make($validatedData['password']);
        } else {
            unset($dataToUpdate['password']); // Don't update password if it's empty
        }

        $student->update($dataToUpdate);

        return redirect()->route('school-superadmin.students.index')
                         ->with('success', 'Student details updated successfully.');
    }

    // ** NEW DESTROY METHOD **
    public function destroy(User $student)
    {
        // Security Check
        if ($student->school_id !== Auth::user()->school_id || $student->role !== 'student') {
            abort(403);
        }

        // Delete photo from storage
        if ($student->student_photo_path) {
            Storage::disk('public')->delete($student->student_photo_path);
        }

        $student->delete();
        
        return redirect()->route('school-superadmin.students.index')
                         ->with('success', 'Student deleted successfully.');
    }
}