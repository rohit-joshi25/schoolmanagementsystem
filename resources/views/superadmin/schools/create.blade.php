@extends('layouts.superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Add New School</h1>
                <a href="{{ route('superadmin.schools.index') }}" class="text-blue-600 hover:underline">
                    ← Back to List
                </a>
            </div>

            <form action="{{ route('superadmin.schools.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- School Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Enter school name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- School Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">School Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Enter school email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Enter phone number">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                        placeholder="Enter school address">{{ old('address') }}</textarea>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Save School
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
