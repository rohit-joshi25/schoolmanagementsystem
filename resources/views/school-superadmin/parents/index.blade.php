@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Parent List</h1>
        {{-- <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Add New Parent</a> --}}
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Linked Students</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($parentsByGuardian as $email => $students)
                    @php $parent = $students->first(); @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $parent->guardian_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $parent->guardian_email }}</div>
                            <div>{{ $parent->guardian_phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @foreach($students as $student)
                                <div class="mb-1">
                                    <span class="font-medium text-gray-800">{{ $student->full_name }}</span>
                                    <span class="text-xs">({{ $student->academicClass->name ?? '' }} - {{ $student->section->name ?? '' }})</span>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No parents found. Guardian details must be added to students first.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection