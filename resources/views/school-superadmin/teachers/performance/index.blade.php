@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Teacher Performance</h1>
        <a href="{{ route('school-superadmin.performance.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Add New Appraisal</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ addCategory: false, editCategoryId: null }">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Manage Performance Categories</h2>
        
        <div class="space-y-2 mb-4">
            @forelse($categories as $category)
                <div x-show="editCategoryId !== {{ $category->id }}" class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <span class="font-medium text-gray-900">{{ $category->name }}</span>
                    </div>
                    <div>
                        <button @click="editCategoryId = {{ $category->id }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                        <form action="{{ route('school-superadmin.performance-categories.destroy', $category) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure? This will delete the category and all associated ratings.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                        </form>
                    </div>
                </div>
                <form x-show="editCategoryId === {{ $category->id }}" action="{{ route('school-superadmin.performance-categories.update', $category) }}" method="POST" class="p-3 bg-blue-50 rounded-lg space-y-2">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $category->name }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                    <div class="flex gap-2">
                        <button type="submit" class="text-sm text-green-600 font-medium">Save</button>
                        <button type="button" @click="editCategoryId = null" class="text-sm text-gray-600 font-medium">Cancel</button>
                    </div>
                </form>
            @empty
                <p class="text-sm text-gray-500">No performance categories created yet. (e.g., "Punctuality", "Student Engagement")</p>
            @endforelse
        </div>
        <div x-show="addCategory" class="p-4 bg-gray-50 rounded-lg border-t pt-4 mt-4">
            <form action="{{ route('school-superadmin.performance-categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">New Category Name *</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="flex gap-4">
                     <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Save Category
                    </button>
                    <button type="button" @click="addCategory = false" class="text-sm text-gray-600">Cancel</button>
                </div>
            </form>
        </div>
        <button x-show="!addCategory" @click="addCategory = true" class="mt-4 text-sm font-medium text-blue-600 hover:underline">+ Add New Category</button>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Appraisal History</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appraiser</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appraisal Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($appraisals as $appraisal)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appraisal->teacher->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appraisal->appraiser->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($appraisal->appraisal_date)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('school-superadmin.performance.show', $appraisal) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No appraisals found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection