<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $activeMenus = [3]; // ID for Payments & Billing menu
        $invoices = Invoice::with('school', 'plan')->latest()->get();
        return view('superadmin.invoices.index', compact('invoices', 'activeMenus'));
    }
}
