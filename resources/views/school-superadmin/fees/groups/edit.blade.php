@extends('layouts.school-superadmin')
@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Fee Group: {{ $feeGroup->name }}</h1>
    <form action="{{ route('school-superadmin.fee-groups.update', $feeGroup) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Group Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $feeGroup->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <textarea name="description" id="description" rows="3" class-="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $feeGroup->description) }}</textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Update Fee Group
            </button>
        </div>
    </form>
</div>
@endsection