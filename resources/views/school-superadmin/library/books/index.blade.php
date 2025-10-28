@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Book Management</h1>
                <button onclick="document.getElementById('addBookForm').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                    Add New Book
                </button>
            </div>

            {{-- Add Book Form --}}
            <div id="addBookForm" class="hidden border-t border-gray-200 pt-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Add New Book</h2>

                <form action="{{ route('school-superadmin.books.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Book Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                placeholder="Enter book title"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Branch --}}
                        <div>
                            <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">Branch *</label>
                            <select name="branch_id" id="branch_id" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}"
                                min="1" required placeholder="Enter quantity"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        </div>

                        {{-- Book Code --}}
                        <div>
                            <label for="book_code" class="block text-sm font-medium text-gray-700 mb-1">Book Code</label>
                            <input type="text" name="book_code" id="book_code" value="{{ old('book_code') }}"
                                placeholder="e.g., B101"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        </div>

                        {{-- Author --}}
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                            <input type="text" name="author" id="author" value="{{ old('author') }}"
                                placeholder="Enter author name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        </div>

                        {{-- Publisher --}}
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                            <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                                placeholder="Enter publisher"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        </div>

                        {{-- ISBN --}}
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN Number</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                                placeholder="Enter ISBN number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('addBookForm').classList.add('hidden')"
                            class="px-5 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition">
                            💾 Save Book
                        </button>
                    </div>
                </form>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Book List --}}
            <div class="mt-10">
                <h2 class="text-xl font-bold text-gray-800 mb-4"> Book Stock List</h2>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Book Code</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Available</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($books as $book)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $book->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->author ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->branch->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->book_code ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->quantity }}</td>
                                    <td
                                        class="px-6 py-4 text-sm font-semibold {{ $book->available_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $book->available_quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        <a href="{{ route('school-superadmin.books.edit', $book) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('school-superadmin.books.destroy', $book) }}"
                                            method="POST" class="inline-block ml-3"
                                            onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No books found. Add
                                        your
                                        first book above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
