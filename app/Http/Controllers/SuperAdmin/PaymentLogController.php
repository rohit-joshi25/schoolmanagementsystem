<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class PaymentLogController extends Controller
{
    public function index()
    {
        $activeMenus = [3]; // ID for Payments & Billing menu
        $logs = PaymentLog::with('invoice.school')->latest()->get();
        return view('superadmin.payment-logs.index', compact('logs', 'activeMenus'));
    }
}
