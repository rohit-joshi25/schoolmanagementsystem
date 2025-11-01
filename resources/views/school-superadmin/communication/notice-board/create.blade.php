@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Notice</h1>
    
    <form action="{{ route('school-superadmin.notices.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('title') border-red-500 @enderror" placeholder="e.g., School Holiday Announcement">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Notice Body *</label>
                <textarea name="body" id="body" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('body') border-red-500 @enderror" placeholder="Write the full content of the notice here...">{{ old('body') }}</textarea>
                @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="publish_date" class="block text-sm font-medium text-gray-700">Publish Date *</label>
                <input type="date" name="publish_date" id="publish_date" value="{{ old('publish_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm" checked>
                <label for="is_published" class="ml-2 block text-sm text-gray-900">Publish Immediately</label>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Notice
            </button>
        </div>
    </form>
</div>
@endsection