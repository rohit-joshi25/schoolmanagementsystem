@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Certificate Template</h1>
    
    <form action="{{ route('school-superadmin.certificates.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror" placeholder="e.g., Transfer Certificate, Bonafide Certificate">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Certificate Body</label>
                <textarea name="body" id="body" rows="15" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono @error('body') border-red-500 @enderror" placeholder="Write your certificate content here. Use placeholders like [student_name], [class_name], [roll_number], etc.">{{ old('body') }}</textarea>
                @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-700">Available Placeholders:</h4>
                <p class="text-xs text-gray-600 mt-2">Use these placeholders in your text. They will be automatically replaced with the student's data when you generate a certificate.</p>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[student_name]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[class_name]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[section_name]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[roll_number]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[admission_no]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[date_of_birth]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[guardian_name]</span>
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-800 text-xs rounded-full">[issue_date]</span>
                </div>
            </div>

        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Template
            </button>
        </div>
    </form>
</div>
@endsection