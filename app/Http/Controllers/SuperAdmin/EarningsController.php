<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        $activeMenus = [3]; // ID for Payments & Billing menu

        // Get all successful payment logs
        $successfulPayments = PaymentLog::with('invoice.school')
                                        ->where('status', 'success')
                                        ->latest()
                                        ->get();

        // Calculate totals
        $totalEarnings = $successfulPayments->sum('amount');
        $commissionRate = 0.10; // 10% commission
        $commissionAmount = $totalEarnings * $commissionRate;
        $netEarnings = $totalEarnings - $commissionAmount;

        return view('superadmin.earnings.index', compact(
            'successfulPayments',
            'totalEarnings',
            'commissionAmount',
            'netEarnings',
            'activeMenus'
        ));
    }
}
