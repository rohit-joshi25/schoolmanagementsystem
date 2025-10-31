@extends('layouts.school-superadmin')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Library Stock Report</h1>

        @forelse($booksByBranch as $branchName => $books)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4">{{ $branchName ?: 'Unassigned Branch' }}</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issued</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($books as $book)
                                @php
                                    $issued = $book->quantity - $book->available_quantity;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->book_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ $issued }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                        {{ $book->available_quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-sm text-gray-500 text-center">No books found in the library. Please add books first.</p>
            </div>
        @endforelse
    </div>
@endsection
