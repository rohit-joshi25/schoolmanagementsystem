<?php

namespace App\Http\Controllers\SchoolSuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use App\Models\Book;
use App\Models\User;
use App\Models\LibraryFine; // <-- Import the new LibraryFine model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // <-- Import Carbon for date calculations

class BookIssueController extends Controller
{
    // Define the fine per day. You can change this value.
    private const FINE_PER_DAY = 0.50; // $0.50 per day

    /**
     * Display the main book issue/return page.
     */
    public function index()
    {
        $activeMenus = [8]; // ID for Library menu
        $school = Auth::user()->school;

        $students = $school->users()->where('role', 'student')->orderBy('full_name')->get();
        $books = $school->books()->where('available_quantity', '>', 0)->orderBy('title')->get();

        $issuedBooks = BookIssue::where('school_id', $school->id)
                                ->where('status', 'issued')
                                ->with(['student', 'book'])
                                ->latest()
                                ->get();

        return view('school-superadmin.library.issue-return.index', compact(
            'students',
            'books',
            'issuedBooks',
            'activeMenus'
        ));
    }

    /**
     * Store a new book issue record.
     */
    public function store(Request $request)
    {
        $school = Auth::user()->school;

        $validatedData = $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::in($school->users()->pluck('id'))],
            'book_id' => ['required', 'exists:books,id', Rule::in($school->books()->pluck('id'))],
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($validatedData['book_id']);

        if ($book->available_quantity <= 0) {
            return redirect()->back()->with('error', 'This book is currently out of stock.');
        }

        DB::beginTransaction();
        try {
            BookIssue::create([
                'school_id' => $school->id,
                'branch_id' => $book->branch_id,
                'book_id' => $book->id,
                'user_id' => $validatedData['user_id'],
                'issue_date' => now()->format('Y-m-d'),
                'due_date' => $validatedData['due_date'],
                'status' => 'issued',
            ]);

            $book->decrement('available_quantity');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred while issuing the book.');
        }

        return redirect()->route('school-superadmin.book-issues.index')
                         ->with('success', 'Book issued successfully.');
    }

    /**
     * Mark a book as returned and create a fine if it's late.
     */
    public function returnBook(BookIssue $bookIssue)
    {
        // Security Check
        if ($bookIssue->school_id !== Auth::user()->school_id) {
            abort(403);
        }

        if ($bookIssue->status == 'returned') {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        DB::beginTransaction();
        try {
            $returnDate = Carbon::now();
            $dueDate = Carbon::parse($bookIssue->due_date);

            // 1. Update the issue record
            $bookIssue->update([
                'return_date' => $returnDate->format('Y-m-d'),
                'status' => 'returned',
            ]);

            // 2. Increment the available quantity of the book
            $bookIssue->book()->increment('available_quantity');

            // 3. ** NEW LOGIC: Check for fines **
            if ($returnDate->isAfter($dueDate)) {
                $daysOverdue = $returnDate->diffInDays($dueDate);
                $totalFine = $daysOverdue * self::FINE_PER_DAY;

                // Create a new fine record
                LibraryFine::create([
                    'school_id' => $bookIssue->school_id,
                    'branch_id' => $bookIssue->branch_id,
                    'user_id' => $bookIssue->user_id,
                    'book_issue_id' => $bookIssue->id,
                    'days_overdue' => $daysOverdue,
                    'fine_rate' => self::FINE_PER_DAY,
                    'total_amount' => $totalFine,
                    'status' => 'pending', // The fine is now pending payment
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while returning the book.');
        }

        return redirect()->route('school-superadmin.book-issues.index')
                         ->with('success', 'Book marked as returned.');
    }
}
