@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Assign Teachers to Subjects</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned Teachers</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($subjects as $subject)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subject->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subject->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @forelse($subject->teachers as $teacher)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mr-1">
                                {{-- ** THIS IS THE FIX ** --}}
                                {{ $teacher->full_name }}
                            </span>
                        @empty
                            <span class="text-gray-400">None Assigned</span>
                        @endforelse
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('school-superadmin.assign-teachers.edit', $subject) }}" class="text-blue-600 hover:text-blue-900">Edit Assignments</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No subjects found. Please add subjects first.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection