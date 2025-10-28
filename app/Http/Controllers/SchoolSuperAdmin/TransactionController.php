<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions (the "Reports" page).
     */
    public function index(Request $request)
    {
        $activeMenus = [7];
        $school = Auth::user()->school;

        $query = $school->transactions()->with(['branch', 'category']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->get();
        $totalIncome = $school->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $school->transactions()->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        return view('school-superadmin.accounting.transactions.index', compact(
            'transactions', 'totalIncome', 'totalExpense', 'netProfit', 'activeMenus'
        ));
    }

    /**
     * Show the form for creating a new INCOME transaction.
     */
    public function createIncome()
    {
        $activeMenus = [7];
        $school = Auth::user()->school;

        $branches = $school->branches()->where('status', 'active')->get();
        $categories = $school->incomeExpenseCategories()->where('type', 'income')->orderBy('name')->get();
        $type = 'income';

        return view('school-superadmin.accounting.transactions.add-income', compact('type', 'branches', 'categories', 'activeMenus'));
    }

    /**
     * Show the form for creating a new EXPENSE transaction.
     */
    public function createExpense()
    {
        $activeMenus = [7];
        $school = Auth::user()->school;

        $branches = $school->branches()->where('status', 'active')->get();
        $categories = $school->incomeExpenseCategories()->where('type', 'expense')->orderBy('name')->get();
        $type = 'expense';

        return view('school-superadmin.accounting.transactions.add-expense', compact('type', 'branches', 'categories', 'activeMenus'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'income_expense_category_id' => 'required|exists:income_expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // For receipts
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('receipts/' . $school->id, 'public');
        }

        $school->transactions()->create(array_merge($validatedData, ['file_path' => $filePath]));

        // ** UPDATED REDIRECT LOGIC **
        if ($validatedData['type'] == 'income') {
            return redirect()->route('school-superadmin.transactions.create_income')
                             ->with('success', 'Income added successfully.');
        } else {
            return redirect()->route('school-superadmin.transactions.create_expense')
                             ->with('success', 'Expense added successfully.');
        }
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Security Check
        if ($transaction->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        if ($transaction->file_path) {
            Storage::disk('public')->delete($transaction->file_path);
        }

        $transaction->delete();

        return redirect()->route('school-superadmin.transactions.index')
                         ->with('success', 'Transaction deleted successfully.');
    }
}
