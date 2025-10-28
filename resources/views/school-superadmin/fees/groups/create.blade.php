@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create New Fee Group</h1>
                <a href="{{ route('school-superadmin.fee-groups.index') }}" class="text-blue-600 hover:underline text-sm">
                    ← Back to Fee Group List
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('school-superadmin.fee-groups.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Group Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Group Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Enter group name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                        (Optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                        placeholder="Add a short description...">{{ old('description') }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                        💾 Save Fee Group
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
