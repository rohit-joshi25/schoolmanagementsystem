@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">
            Timetable for: {{ $section->academicClass->name }} - Section {{ $section->name }}
            <span class="text-sm font-normal text-gray-600">({{ $section->academicClass->branch->name }})</span>
        </h1>
        <a href="{{ route('school-superadmin.timetable.index') }}" class="text-sm text-blue-600 hover:underline">← Select Another Section</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Add New Entry Form --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Add New Timetable Entry</h2>
        <form action="{{ route('school-superadmin.timetable.store', $section) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700">Day</label>
                    <select name="day_of_week" id="day_of_week" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                        @foreach($daysOfWeek as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                 <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" id="subject_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                         <option value="">-- Select --</option>
                         @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} {{ $subject->code ? '('.$subject->code.')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                 <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Teacher</label>
                    <select name="teacher_id" id="teacher_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                         <option value="">-- Select --</option>
                         @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="start_time" id="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
                 <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" name="end_time" id="end_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                </div>
            </div>
             <div class="mt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Add Entry
                </button>
            </div>
        </form>
    </div>

    {{-- Timetable Display Table --}}
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Current Timetable</h2>
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($daysOfWeek as $day)
                    @php $entriesForDay = $timetableEntries->get($day); @endphp
                    @if($entriesForDay && $entriesForDay->count() > 0)
                        @foreach($entriesForDay as $index => $entry)
                            <tr>
                                @if($index === 0)
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 border-r" rowspan="{{ $entriesForDay->count() }}">{{ $day }}</td>
                                @endif
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($entry->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($entry->end_time)->format('h:i A') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $entry->subject->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $entry->teacher->full_name ?? 'N/A' }}</td>
                                
                                <td class="px-4 py-2 whitespace-nowrap text-right text-sm">
                                    <form action="{{ route('school-superadmin.timetable.destroy', $entry) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Timetable is empty. Add entries using the form above.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection