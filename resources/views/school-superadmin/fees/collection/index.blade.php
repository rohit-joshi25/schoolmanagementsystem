@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Collect Student Fees</h1>

            {{-- Search Form --}}
            <form method="GET" action="{{ route('school-superadmin.payment-collection.index') }}"
                class="flex items-end gap-4">
                <div class="flex-grow">
                    <label for="search_query" class="block text-sm font-medium text-gray-700 mb-1">Search Student</label>
                    <input type="text" name="search_query" id="search_query" value="{{ request('search_query') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                        placeholder="Enter Student Name, Email, or Admission No...">
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                    <i data-lucide="search" class="w-4 h-4"></i> Search
                </button>
            </form>

            {{-- Search Results --}}
            @if (isset($students))
                <div class="mt-10 border-t pt-6">
                    <h2 class="text-xl font-bold text-gray-700 mb-4">Search Results</h2>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student
                                        Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Class</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($students as $student)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $student->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $student->academicClass->name ?? 'N/A' }} -
                                            {{ $student->section->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('school-superadmin.payment-collection.show', $student) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 font-semibold rounded-full text-xs hover:bg-blue-200 transition">
                                                Collect Fees <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            No students found matching your search.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
