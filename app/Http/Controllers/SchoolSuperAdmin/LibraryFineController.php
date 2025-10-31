<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LibraryFine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryFineController extends Controller
{
    /**
     * Display a listing of all library fines.
     */
    public function index(Request $request)
    {
        $activeMenus = [8]; // ID for Library menu
        $school = Auth::user()->school;

        $query = $school->libraryFines()->with(['student', 'bookIssue.book']);

        // Filter by status (pending/paid)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fines = $query->latest()->get();

        return view('school-superadmin.library.fines.index', compact('fines', 'activeMenus'));
    }

    /**
     * Mark a fine as paid.
     */
    public function markAsPaid(LibraryFine $fine)
    {
        // Security Check
        if ($fine->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $fine->update(['status' => 'paid']);

        return redirect()->route('school-superadmin.library-fines.index')
                         ->with('success', 'Fine marked as paid successfully.');
    }
}
