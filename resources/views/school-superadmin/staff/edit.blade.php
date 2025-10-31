@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Edit Staff Member: {{ $staff->full_name }}</h1>
            </div>

            <form action="{{ route('school-superadmin.staff.update', $staff) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $staff->full_name) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Login Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="role" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}"
                                    {{ old('role', $staff->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">Assign to Branch</label>
                        <select name="branch_id" id="branch_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ old('branch_id', $staff->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2 border-t pt-6">
                        <p class="text-sm text-gray-500 mb-4">Leave the password fields blank if you do not want to change
                            the password.</p>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                    </div>
                </div>
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Update Staff Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
