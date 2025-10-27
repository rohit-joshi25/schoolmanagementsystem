<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\StudentFee;
use App\Models\StudentPaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeReportController extends Controller
{
    /**
     * Display the fees report dashboard.
     */
    public function index()
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school;

        // Get all the master fee invoices for the school
        $studentFees = $school->studentFees()->get();

        // Calculate the totals
        $totalAllocated = $studentFees->sum('amount');
        $totalCollected = $studentFees->sum('amount_paid');
        $totalDue = $totalAllocated - $totalCollected;

        // Get the most recent 10 payments for the "Recent Transactions" log
        $recentPayments = StudentPaymentLog::where('school_id', $school->id)
                                           ->with(['student', 'studentFee.feeAllocation.feeType.feeGroup'])
                                           ->latest()
                                           ->take(10)
                                           ->get();

        return view('school-superadmin.fees.reports.index', compact(
            'totalAllocated',
            'totalCollected',
            'totalDue',
            'recentPayments',
            'activeMenus'
        ));
    }
}