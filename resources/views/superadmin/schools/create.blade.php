@extends('layouts.superadmin')

@section('content')
    <div class="max-w-5xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8 border-b pb-4">
                <h1 class="text-3xl font-semibold text-gray-800">Add New School</h1>
                <a href="{{ route('superadmin.schools.index') }}"
                    class="text-blue-600 font-medium hover:text-blue-800 transition">
                    ← Back to List
                </a>
            </div>

            <form action="{{ route('superadmin.schools.store') }}" method="POST" class="space-y-10">
                @csrf

                {{-- School Details Section --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">School Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- School Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('name') border-red-500 @enderror"
                                placeholder="Enter school name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- School Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">School Contact
                                Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('email') border-red-500 @enderror"
                                placeholder="example@school.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                                placeholder="+1 (000) 000-0000">
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                                placeholder="Enter school address">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Superadmin Account Section --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">School Superadmin Account</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Admin Name --}}
                        <div>
                            <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">Admin Name</label>
                            <input type="text" name="admin_name" id="admin_name" value="{{ old('admin_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('admin_name') border-red-500 @enderror"
                                placeholder="Enter admin name">
                            @error('admin_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Admin Email --}}
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Admin Login
                                Email</label>
                            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('admin_email') border-red-500 @enderror"
                                placeholder="admin@example.com">
                            @error('admin_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('password') border-red-500 @enderror"
                                placeholder="Enter password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm"
                                placeholder="Re-enter password">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        💾 Save & Create Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
