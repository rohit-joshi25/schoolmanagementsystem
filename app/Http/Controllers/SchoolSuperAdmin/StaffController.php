<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $activeMenus = [1];
        $school = Auth::user()->school;

        $staff = $school->users()
                        ->where('role', '!=', 'student')
                        ->where('role', '!=', 'school_superadmin')
                        ->with('branch')
                        ->latest()
                        ->get();

        return view('school-superadmin.staff.index', compact('staff', 'activeMenus'));
    }

    public function create()
    {
        $activeMenus = [1];
        $school = Auth::user()->school;
        $branches = $school->branches()->where('status', 'active')->get();
        $roles = ['admin', 'teacher', 'accountant'];

        return view('school-superadmin.staff.create', compact('branches', 'roles', 'activeMenus'));
    }

    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'teacher', 'accountant'])],
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'school_id' => $school->id,
            'branch_id' => $validatedData['branch_id'],
        ]);

        return redirect()->route('school-superadmin.staff.index')
                         ->with('success', 'Staff member created successfully.');
    }

    // ** NEW EDIT METHOD **
    public function edit(User $staff)
    {
        // Security Check: Make sure the staff member belongs to the user's school
        if ($staff->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [1];
        $school = Auth::user()->school;
        $branches = $school->branches()->where('status', 'active')->get();
        $roles = ['admin', 'teacher', 'accountant'];

        return view('school-superadmin.staff.edit', compact('staff', 'branches', 'roles', 'activeMenus'));
    }

    // ** NEW UPDATE METHOD **
    public function update(Request $request, User $staff)
    {
        // Security Check
        if ($staff->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'teacher', 'accountant'])],
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
        ]);

        // Update the user's main details
        $staff->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'branch_id' => $validatedData['branch_id'],
        ]);

        // Only update the password if a new one was provided
        if (!empty($validatedData['password'])) {
            $staff->update(['password' => Hash::make($validatedData['password'])]);
        }

        return redirect()->route('school-superadmin.staff.index')
                         ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff)
    {
        if ($staff->school_id !== Auth::user()->school_id) {
            abort(403);
        }
        $staff->delete();
        return redirect()->route('school-superadmin.staff.index')
                         ->with('success', 'Staff member deleted successfully.');
    }
}
