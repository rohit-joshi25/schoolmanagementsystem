<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentFee;
use App\Models\StudentPaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentCollectionController extends Controller
{
    /**
     * Show the student search page for fee collection.
     */
    public function index(Request $request)
    {
        $activeMenus = [6]; // ID for Fees Management menu
        $school = Auth::user()->school;
        $students = null;

        if ($request->filled('search_query')) {
            $query = $request->input('search_query');
            $students = $school->users()
                ->where('role', 'student')
                ->where(function($q) use ($query) {
                    $q->where('full_name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('admission_no', 'like', "%{$query}%");
                })
                ->with(['academicClass', 'section'])
                ->get();
        }

        return view('school-superadmin.fees.collection.index', compact('students', 'activeMenus'));
    }

    /**
     * Show the fee details and payment form for a specific student.
     */
    public function show(User $student)
    {
        // Security Check
        if ($student->school_id !== Auth::user()->school_id || $student->role !== 'student') {
            abort(403);
        }

        $activeMenus = [6];
        $student->load(['studentFees.feeAllocation.feeType.feeGroup', 'studentFees.payments']);
        
        $paymentMethods = ['Cash', 'Card', 'Bank Transfer', 'Online'];

        return view('school-superadmin.fees.collection.show', compact('student', 'paymentMethods', 'activeMenus'));
    }

    /**
     * Store a new payment for a specific student fee.
     */
    public function storePayment(Request $request, StudentFee $studentFee)
    {
        // Security Check
        if ($studentFee->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:50',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $amountToPay = $validatedData['amount'];
        $totalOwed = $studentFee->amount - $studentFee->amount_paid;

        // Prevent overpayment
        if ($amountToPay > $totalOwed) {
            return redirect()->back()->with('error', 'Payment amount cannot be greater than the remaining due amount.');
        }

        DB::beginTransaction();
        try {
            // 1. Create the payment log
            $studentFee->payments()->create([
                'school_id' => $studentFee->school_id,
                'branch_id' => $studentFee->branch_id,
                'user_id' => $studentFee->user_id,
                'amount' => $amountToPay,
                'payment_method' => $validatedData['payment_method'],
                'payment_date' => $validatedData['payment_date'],
                'notes' => $validatedData['notes'],
            ]);

            // 2. Update the master fee invoice
            $newAmountPaid = $studentFee->amount_paid + $amountToPay;
            $newStatus = ($newAmountPaid >= $studentFee->amount) ? 'paid' : 'partial';

            $studentFee->update([
                'amount_paid' => $newAmountPaid,
                'status' => $newStatus,
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the payment.');
        }

        return redirect()->route('school-superadmin.payment-collection.show', $studentFee->student)
                         ->with('success', 'Payment recorded successfully.');
    }
}