@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Collect Student Fees</h1>
        
        <form method="GET" action="{{ route('school-superadmin.payment-collection.index') }}" class="flex gap-4">
            <div class="flex-1">
                <label for="search_query" class="block text-sm font-medium text-gray-700">Search Student</label>
                <input type="text" name="search_query" id="search_query" value="{{ request('search_query') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" 
                       placeholder="Enter Student Name, Email, or Admission No...">
            </div>
            <div class="flex-shrink-0">
                <label class="block text-sm">&nbsp;</label> <!-- Placeholder for alignment -->
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- Search Results --}}
    @if(isset($students))
    <div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Search Results</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $student->academicClass->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('school-superadmin.payment-collection.show', $student) }}" class="text-blue-600 hover:text-blue-900">
                                Collect Fees
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No students found matching your search.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection