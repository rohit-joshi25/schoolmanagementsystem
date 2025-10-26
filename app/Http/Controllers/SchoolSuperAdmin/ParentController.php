<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    /**
     * Display a list of all parents/guardians, grouped by their email.
     */
    public function index()
    {
        $activeMenus = [5]; // ID for Parents menu
        $school = Auth::user()->school;

        // Get all students that have guardian information,
        // eager-load their class/section,
        // and then group them by the guardian's email.
        $studentsWithGuardians = $school->users()
            ->where('role', 'student')
            ->whereNotNull('guardian_email')
            ->with(['academicClass', 'section'])
            ->get();
        
        // Group the students by their guardian's email
        $parentsByGuardian = $studentsWithGuardians->groupBy('guardian_email');

        return view('school-superadmin.parents.index', compact('parentsByGuardian', 'activeMenus'));
    }
}