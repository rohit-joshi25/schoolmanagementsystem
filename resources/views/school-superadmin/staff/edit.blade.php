@extends('layouts.school-superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Staff Member: {{ $staff->name }}</h1>

        <form action="{{ route('school-superadmin.staff.update', $staff) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Login Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}"
                                    {{ old('role', $staff->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Assign to Branch</label>
                        <select name="branch_id" id="branch_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Update Staff Account
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
