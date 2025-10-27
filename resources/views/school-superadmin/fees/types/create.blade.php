@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Fee Type</h1>
    
    <form action="{{ route('school-superadmin.fee-types.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="fee_group_id" class="block text-sm font-medium text-gray-700">Fee Group *</label>
                <select name="fee_group_id" id="fee_group_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('fee_group_id') border-red-500 @enderror">
                    <option value="">-- Select a Fee Group --</option>
                    @foreach($feeGroups as $group)
                        <option value="{{ $group->id }}" {{ old('fee_group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
                @error('fee_group_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Fee Type Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror" placeholder="e.g., Monthly Tuition Fee, Bus Fee">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fee_code" class="block text-sm font-medium text-gray-700">Fee Code (Optional)</label>
                <input type="text" name="fee_code" id="fee_code" value="{{ old('fee_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('fee_code') border-red-500 @enderror" placeholder="e.g., TUI-001, BUS-001">
                @error('fee_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
            </div>

        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Fee Type
            </button>
        </div>
    </form>
</div>
@endsection