@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800"> Edit Book: {{ $book->title }}</h1>
                <a href="{{ route('school-superadmin.books.index') }}" class="text-blue-600 hover:underline text-sm">
                    ← Back to Book List
                </a>
            </div>

            <form action="{{ route('school-superadmin.books.update', $book) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Book Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Book Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                            required placeholder="Enter book title"
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
                                    {{ old('branch_id', $book->branch_id) == $branch->id ? 'selected' : '' }}>
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
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $book->quantity) }}"
                            required min="1" placeholder="Enter quantity"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Book Code --}}
                    <div>
                        <label for="book_code" class="block text-sm font-medium text-gray-700 mb-1">Book Code</label>
                        <input type="text" name="book_code" id="book_code"
                            value="{{ old('book_code', $book->book_code) }}" placeholder="e.g., B101"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>

                    {{-- Author --}}
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                            placeholder="Enter author name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>

                    {{-- Publisher --}}
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                        <input type="text" name="publisher" id="publisher"
                            value="{{ old('publisher', $book->publisher) }}" placeholder="Enter publisher"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>

                    {{-- ISBN --}}
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN Number</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                            placeholder="Enter ISBN number"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
