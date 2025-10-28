<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\IncomeExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IncomeExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeMenus = [7]; // ID for Income/Expense menu
        $school = Auth::user()->school;

        $incomeCategories = $school->incomeExpenseCategories()->where('type', 'income')->latest()->get();
        $expenseCategories = $school->incomeExpenseCategories()->where('type', 'expense')->latest()->get();

        return view('school-superadmin.accounting.categories.index', compact('incomeCategories', 'expenseCategories', 'activeMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('income_expense_categories')->where('school_id', $school->id)],
            'type' => 'required|in:income,expense',
        ]);

        $school->incomeExpenseCategories()->create($validatedData);

        return redirect()->route('school-superadmin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomeExpenseCategory $category)
    {
        // Security Check
        if ($category->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('income_expense_categories')->where('school_id', $school->id)->ignore($category->id)],
            'type' => 'required|in:income,expense',
        ]);

        $category->update($validatedData);

        return redirect()->route('school-superadmin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeExpenseCategory $category)
    {
        // Security Check
        if ($category->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('school-superadmin.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
