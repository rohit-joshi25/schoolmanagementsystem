@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Fee Type: <span
                        class="text-blue-600">{{ $feeType->name }}</span></h1>
                <a href="{{ route('school-superadmin.fee-types.index') }}" class="text-blue-600 hover:underline text-sm">
                    ← Back to Fee Type List
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('school-superadmin.fee-types.update', $feeType) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Fee Group --}}
                    <div>
                        <label for="fee_group_id" class="block text-sm font-medium text-gray-700 mb-1">Fee Group *</label>
                        <select name="fee_group_id" id="fee_group_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('fee_group_id') border-red-500 @enderror">
                            <option value="">-- Select a Fee Group --</option>
                            @foreach ($feeGroups as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('fee_group_id', $feeType->fee_group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('fee_group_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fee Type Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Fee Type Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $feeType->name) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Fee Code --}}
                <div>
                    <label for="fee_code" class="block text-sm font-medium text-gray-700 mb-1">Fee Code (Optional)</label>
                    <input type="text" name="fee_code" id="fee_code" value="{{ old('fee_code', $feeType->fee_code) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                        (Optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">{{ old('description', $feeType->description) }}</textarea>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                        Update Fee Type
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
