@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Subject</h1>
    <form action="{{ route('school-superadmin.subjects.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name (e.g., Mathematics)</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Subject Code (Optional)</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('code') border-red-500 @enderror">
                    @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Subject Type</label>
                <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="Theory" {{ old('type') == 'Theory' ? 'selected' : '' }}>Theory</option>
                    <option value="Practical" {{ old('type') == 'Practical' ? 'selected' : '' }}>Practical</option>
                </select>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Subject
            </button>
        </div>
    </form>
</div>
@endsection