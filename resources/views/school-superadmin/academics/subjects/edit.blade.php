@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Subject: {{ $subject->name }}</h1>
    <form action="{{ route('school-superadmin.subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Subject Code (Optional)</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $subject->code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('code') border-red-500 @enderror">
                    @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Subject Type</label>
                <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="Theory" {{ old('type', $subject->type) == 'Theory' ? 'selected' : '' }}>Theory</option>
                    <option value="Practical" {{ old('type', $subject->type) == 'Practical' ? 'selected' : '' }}>Practical</option>
                </select>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Update Subject
            </button>
        </div>
    </form>
</div>
@endsection 