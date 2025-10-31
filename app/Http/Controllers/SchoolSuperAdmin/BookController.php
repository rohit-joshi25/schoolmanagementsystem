<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index()
    {
        $activeMenus = [8]; // ID for Library menu
        $school = Auth::user()->school;

        // Eager load branch information
        $books = $school->books()->with('branch')->latest()->get();
        $branches = $school->branches()->where('status', 'active')->get();

        return view('school-superadmin.library.books.index', compact('books', 'branches', 'activeMenus'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'book_code' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        // When a book is first added, its available quantity is the same as its total quantity
        $validatedData['available_quantity'] = $validatedData['quantity'];

        $school->books()->create($validatedData);

        return redirect()->route('school-superadmin.books.index')
                         ->with('success', 'Book added successfully.');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        // Security Check
        if ($book->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $activeMenus = [8];
        $school = Auth::user()->school;
        $branches = $school->branches()->where('status', 'active')->get();

        return view('school-superadmin.library.books.edit', compact('book', 'branches', 'activeMenus'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        // Security Check
        if ($book->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $school = Auth::user()->school;
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'branch_id' => ['required', 'exists:branches,id', Rule::in($school->branches->pluck('id'))],
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'book_code' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);

        // A simple way to handle available quantity.
        // A more complex system would track issued books.
        $validatedData['available_quantity'] = $validatedData['quantity'];

        $book->update($validatedData);

        return redirect()->route('school-superadmin.books.index')
                         ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        // Security Check
        if ($book->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        $book->delete();

        return redirect()->route('school-superadmin.books.index')
                         ->with('success', 'Book deleted successfully.');
    }
    public function stockReport()
    {
        $activeMenus = [8]; // ID for Library menu
        $school = Auth::user()->school;

        // Get all books, eager load their branch, and group them by branch_id
        $books = $school->books()->with('branch')->orderBy('branch_id')->get();

        $booksByBranch = $books->groupBy('branch.name'); // Group by the branch's name

        return view('school-superadmin.library.reports.stock', compact('booksByBranch', 'activeMenus'));
    }
}
