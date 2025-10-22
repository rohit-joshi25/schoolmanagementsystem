<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of all leave requests for the school.
     */
    public function index(Request $request)
    {
        $activeMenus = [3]; // ID for Students menu
        $school = Auth::user()->school;
        
        $query = LeaveRequest::where('school_id', $school->id)
                             ->with('student.section', 'student.academicClass'); // Eager load student info

        // Filter by status (e.g., pending, approved)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->latest()->get();

        return view('school-superadmin.academics.students.leave-requests', compact('leaveRequests', 'activeMenus'));
    }

    /**
     * Update the status of a leave request (Approve/Reject).
     */
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        // Security Check
        if ($leaveRequest->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update([
            'status' => $validated['status'],
            'action_by_user_id' => Auth::id(),
        ]);

        return redirect()->route('school-superadmin.leave-requests.index')
                         ->with('success', 'Leave request has been ' . $validated['status'] . '.');
    }
}