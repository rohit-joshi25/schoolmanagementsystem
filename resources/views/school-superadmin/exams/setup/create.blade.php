@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Add New Exam</h1>
            </div>

            <form action="{{ route('school-superadmin.exams.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Exam Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="e.g., Mid-Term Exam 2025">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="grade_system_id" class="block text-sm font-medium text-gray-700 mb-1">Grade System
                            *</label>
                        <select name="grade_system_id" id="grade_system_id" required
                            class="w-full border {{ $errors->has('grade_system_id') ? 'border-red-500' : 'border-gray-300' }} rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <option value="">-- Select a Grade System --</option>
                            @foreach ($gradeSystems as $system)
                                <option value="{{ $system->id }}"
                                    {{ old('grade_system_id') == $system->id ? 'selected' : '' }}>{{ $system->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('grade_system_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Save Exam
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
