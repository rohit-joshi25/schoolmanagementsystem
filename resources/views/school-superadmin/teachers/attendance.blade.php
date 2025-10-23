@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form to Select Criteria -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Select Teacher Attendance Criteria</h2>
        
        <form method="GET" action="{{ route('school-superadmin.teachers.attendance.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                    <select name="branch_id" id="branch_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selectedData['branch_id'] ?? '' == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="attendance_date" class="block text-sm font-medium text-gray-700">Attendance Date *</label>
                    <input type="date" name="attendance_date" id="attendance_date" value="{{ $selectedData['attendance_date'] ?? now()->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Attendance Sheet -->
    @if(isset($teachers))
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Mark Teacher Attendance</h2>
        
        <form action="{{ route('school-superadmin.teachers.attendance.store') }}" method="POST">
            @csrf
            {{-- Pass hidden fields back to the controller --}}
            <input type="hidden" name="branch_id" value="{{ $selectedData['branch_id'] }}">
            <input type="hidden" name="attendance_date" value="{{ $selectedData['attendance_date'] }}">
            
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($teachers as $teacher)
                        @php
                            $currentStatus = $attendanceRecords[$teacher->id] ?? 'present';
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $teacher->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($teacher->role) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $teacher->id }}]" value="present" class="form-radio" {{ $currentStatus == 'present' ? 'checked' : '' }}>
                                        <span class="ml-2">Present</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $teacher->id }}]" value="absent" class="form-radio" {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                                        <span class="ml-2">Absent</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $teacher->id }}]" value="late" class="form-radio" {{ $currentStatus == 'late' ? 'checked' : '' }}>
                                        <span class="ml-2">Late</span>
                                    </label>
                                     <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $teacher->id }}]" value="half_day" class="form-radio" {{ $currentStatus == 'half_day' ? 'checked' : '' }}>
                                        <span class="ml-2">Half Day</span>
                                    </label>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <input type="text" name="notes[{{ $teacher->id }}]" class="text-sm block w-full rounded-md border-gray-300 shadow-sm" placeholder="Optional notes...">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No teachers found in this branch.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($teachers) && !$teachers->isEmpty())
            <div class="mt-6 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    Save Attendance
                </button>
            </div>
            @endif
        </form>
    </div>
    @endif
</div>

@endsection