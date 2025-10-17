@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Branch: {{ $branch->name }}</h1>
                <a href="{{ route('school-superadmin.branches.index') }}" class="text-blue-600 hover:underline">
                    ← Back to Branch List
                </a>
            </div>

            <form action="{{ route('school-superadmin.branches.update', $branch) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Branch Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Branch Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="Enter branch name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Branch Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Branch Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $branch->email) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('email') border-red-500 @enderror"
                            placeholder="Enter branch email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Enter phone number">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <option value="active" {{ old('status', $branch->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $branch->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    {{-- Address --}}
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Enter branch address">{{ old('address', $branch->address) }}</textarea>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200">
                        💾 Update Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
