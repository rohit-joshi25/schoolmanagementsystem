@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8 p-6">
        {{-- Page Title --}}
        <h1 class="text-3xl font-bold text-gray-800">Income & Expense Categories</h1>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Add New Category Section --}}
        <div class="bg-white p-6 rounded-2xl shadow-md" x-data="{ addFormOpen: false }">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Add New Category</h2>
                <button @click="addFormOpen = !addFormOpen"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    <i data-lucide="plus" class="w-4 h-4"></i> Add Category
                </button>
            </div>

            {{-- Add Form --}}
            <div x-show="addFormOpen" x-collapse x-transition class="mt-4 p-6 bg-gray-50 rounded-lg border space-y-4">
                <form action="{{ route('school-superadmin.categories.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Category Name --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Category Name
                                *</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                                placeholder="e.g., Staff Salary, Donations">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category Type --}}
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Category Type
                                *</label>
                            <select name="type" id="type" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            Save Category
                        </button>
                        <button type="button" @click="addFormOpen = false"
                            class="text-sm text-gray-600 hover:underline">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Manage Existing Categories --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" x-data="{ editId: null }">
            {{-- Income Categories --}}
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4"> Income Categories</h2>
                <div class="space-y-3">
                    @forelse($incomeCategories as $category)
                        {{-- Display Row --}}
                        <div x-show="editId !== {{ $category->id }}"
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border">
                            <span class="font-medium text-gray-900">{{ $category->name }}</span>
                            <div class="flex gap-3">
                                <button @click="editId = {{ $category->id }}"
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                                <form action="{{ route('school-superadmin.categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Form --}}
                        <form x-show="editId === {{ $category->id }}" x-transition
                            action="{{ route('school-superadmin.categories.update', $category) }}" method="POST"
                            class="p-4 bg-blue-50 rounded-lg space-y-3 border border-blue-100">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="income">
                            <input type="text" name="name" value="{{ $category->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="text-sm text-green-600 font-medium hover:underline">Save</button>
                                <button type="button" @click="editId = null"
                                    class="text-sm text-gray-600 font-medium hover:underline">Cancel</button>
                            </div>
                        </form>
                    @empty
                        <p class="text-sm text-gray-500 italic">No income categories created yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Expense Categories --}}
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Expense Categories</h2>
                <div class="space-y-3">
                    @forelse($expenseCategories as $category)
                        {{-- Display Row --}}
                        <div x-show="editId !== {{ $category->id }}"
                            class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border">
                            <span class="font-medium text-gray-900">{{ $category->name }}</span>
                            <div class="flex gap-3">
                                <button @click="editId = {{ $category->id }}"
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                                <form action="{{ route('school-superadmin.categories.destroy', $category) }}"
                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit Form --}}
                        <form x-show="editId === {{ $category->id }}" x-transition
                            action="{{ route('school-superadmin.categories.update', $category) }}" method="POST"
                            class="p-4 bg-blue-50 rounded-lg space-y-3 border border-blue-100">
                            @csrf @method('PUT')
                            <input type="hidden" name="type" value="expense">
                            <input type="text" name="name" value="{{ $category->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="text-sm text-green-600 font-medium hover:underline">Save</button>
                                <button type="button" @click="editId = null"
                                    class="text-sm text-gray-600 font-medium hover:underline">Cancel</button>
                            </div>
                        </form>
                    @empty
                        <p class="text-sm text-gray-500 italic">No expense categories created yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
