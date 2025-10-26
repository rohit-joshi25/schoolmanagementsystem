@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Payroll Management</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Section 1: Manage Salary Grades -->
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ addGrade: false, editGradeId: null }">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Manage Salary Grades</h2>
        
        <!-- List Existing Grades -->
        <div class="space-y-2 mb-4">
            @forelse($salaryGrades as $grade)
                <div x-show="editGradeId !== {{ $grade->id }}" class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <span class="font-medium text-gray-900">{{ $grade->name }}</span>
                        <p class="text-sm text-gray-600">{{ $grade->description }}</p>
                    </div>
                    <div>
                        <button @click="editGradeId = {{ $grade->id }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                        <form action="{{ route('school-superadmin.salary-grades.destroy', $grade) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure? This may affect staff assigned to this grade.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Grade Form (hidden by default) -->
                <form x-show="editGradeId === {{ $grade->id }}" action="{{ route('school-superadmin.salary-grades.update', $grade) }}" method="POST" class="p-3 bg-blue-50 rounded-lg space-y-2">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $grade->name }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                    <input type="text" name="description" value="{{ $grade->description }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Description (optional)">
                    <div class="flex gap-2">
                        <button type="submit" class="text-sm text-green-600 font-medium">Save</button>
                        <button type="button" @click="editGradeId = null" class="text-sm text-gray-600 font-medium">Cancel</button>
                    </div>
                </form>
            @empty
                <p class="text-sm text-gray-500">No salary grades created yet.</p>
            @endforelse
        </div>

        <!-- Add New Grade Form (hidden by default) -->
        <div x-show="addGrade" class="p-4 bg-gray-50 rounded-lg border-t pt-4 mt-4">
            <form action="{{ route('school-superadmin.salary-grades.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">New Grade Name *</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                 <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <input type="text" name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="flex gap-4">
                     <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Save Grade
                    </button>
                    <button type="button" @click="addGrade = false" class="text-sm text-gray-600">Cancel</button>
                </div>
            </form>
        </div>

        <button x-show="!addGrade" @click="addGrade = true" class="mt-4 text-sm font-medium text-blue-600 hover:underline">+ Add New Salary Grade</button>
    </div>

    <!-- Section 2: Assign Salaries to Staff -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Staff Salary Management</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Basic Salary ($)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($staff as $user)
                    <form action="{{ route('school-superadmin.payroll.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <select name="salary_grade_id" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    <option value="">-- Not Assigned --</option>
                                    @foreach($salaryGrades as $grade)
                                        <option value="{{ $grade->id }}" {{ $user->salary_grade_id == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $user->basic_salary) }}" placeholder="0.00" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="submit" class="text-blue-600 hover:text-blue-900">Save</button>
                            </td>
                        </tr>
                    </form>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No staff members found. Add staff via the 'Teachers' menu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection