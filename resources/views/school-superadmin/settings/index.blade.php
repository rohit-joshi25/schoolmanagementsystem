@extends('layouts.school-superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">School Settings</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="border-b pb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Update School Logo</h2>

            <form action="{{ route('school-superadmin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-6">
                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">Current Logo</span>
                        {{-- ** THIS IS THE CORRECTED LOGIC ** --}}
                        @if (Auth::user()->school && Auth::user()->school->logo_path)
                            <img src="{{ asset('storage/' . Auth::user()->school->logo_path) }}" alt="School Logo"
                                class="h-16 w-16 rounded-full object-cover">
                        @else
                            <span class="flex items-center justify-center h-16 w-16 rounded-full bg-gray-200 text-gray-500">
                                <i data-lucide="image-off" class="w-8 h-8"></i>
                            </span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="logo" class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                        <input type="file" name="logo" id="logo" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Upload Logo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
