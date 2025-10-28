@extends('layouts.school-superadmin')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Issue / Return Books</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Section 1: Issue New Book -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Issue New Book</h2>

            <form action="{{ route('school-superadmin.book-issues.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Student *</label>
                        <select name="user_id" id="user_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Student --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} (Class: {{ $student->academicClass->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="book_id" class="block text-sm font-medium text-gray-700">Book *</label>
                        <select name="book_id" id="book_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Book (Available Only) --</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} ({{ $book->book_code }})</option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                        <input type="date" name="due_date" id="due_date"
                            value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Issue Book
                    </button>
                </div>
            </form>
        </div>

        <!-- Section 2: Currently Issued Books -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Currently Issued Books (Not Returned)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($issuedBooks as $issue)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $issue->student->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $issue->book->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($issue->issue_date)->format('d M, Y') }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm {{ now()->gt($issue->due_date) ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($issue->due_date)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('school-superadmin.book-issues.return', $issue) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Mark this book as returned?');">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Mark as
                                            Returned</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    books are currently issued.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
