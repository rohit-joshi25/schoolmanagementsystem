@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Assign Teachers for: {{ $subject->name }}</h1>
        <a href="{{ route('school-superadmin.assign-teachers.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
    </div>

    <form action="{{ route('school-superadmin.assign-teachers.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Teachers for this Subject:</label>
            
            @if($teachers->isEmpty())
                <p class="text-sm text-gray-500">No teachers found in your school. Please add staff with the 'teacher' role first.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 border p-4 rounded-md max-h-60 overflow-y-auto">
                    @foreach($teachers as $teacher)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="teachers[]" value="{{ $teacher->id }}" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   {{ in_array($teacher->id, $assignedTeacherIds) ? 'checked' : '' }}>
                            
                            {{-- ** THIS IS THE FIX ** --}}
                            <span class="text-sm text-gray-700">{{ $teacher->full_name }}</span>
                        </label>
                    @endforeach
                </div>
                 @error('teachers') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @endif
        </div>

        @if(!$teachers->isEmpty())
        <div class="mt-8 border-t pt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Update Assignments
            </button>
        </div>
        @endif
    </form>
</div>
@endsection