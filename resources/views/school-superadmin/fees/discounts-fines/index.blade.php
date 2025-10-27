@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Manage Discounts & Fines</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Section 1: Add New Discount or Fine -->
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ addFormOpen: false }">
        <button @click="addFormOpen = !addFormOpen" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mb-4">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New
        </button>

        <!-- Add New Form (hidden by default) -->
        <div x-show="addFormOpen" x-collapse class="p-4 bg-gray-50 rounded-lg border pt-4 mt-4">
            <form action="{{ route('school-superadmin.fee-adjustments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Sibling Discount, Late Fee">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="discount">Discount</option>
                            <option value="fine">Fine</option>
                        </select>
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                        <input type="number" step="0.01" name="amount" id="amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="0.00">
                        @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center pt-6">
                        <input type="checkbox" name="is_percentage" id="is_percentage" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm">
                        <label for="is_percentage" class="ml-2 block text-sm text-gray-900">Amount is a percentage (%)</label>
                    </div>
                </div>
                <div class="flex gap-4">
                     <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Save
                    </button>
                    <button type="button" @click="addFormOpen = false" class="text-sm text-gray-600">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section 2: Manage Existing Discounts & Fines -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="{ editId: null }">
        
        <!-- Discounts List -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Discounts</h2>
            <div class="space-y-2">
                @forelse($discounts as $item)
                    <!-- Display Row -->
                    <div x-show="editId !== {{ $item->id }}" class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-medium text-gray-900">{{ $item->name }}</span>
                            <span class="text-sm text-gray-600 ml-2">({{ $item->is_percentage ? $item->amount.'%' : '$'.number_format($item->amount, 2) }})</span>
                        </div>
                        <div>
                            <button @click="editId = {{ $item->id }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                            <form action="{{ route('school-superadmin.fee-adjustments.destroy', $item) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                    <!-- Edit Form -->
                    <form x-show="editId === {{ $item->id }}" action="{{ route('school-superadmin.fee-adjustments.update', $item) }}" method="POST" class="p-3 bg-blue-50 rounded-lg space-y-3">
                        @csrf @method('PUT')
                        <input type="hidden" name="type" value="discount">
                        <input type="text" name="name" value="{{ $item->name }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                        <input type="number" step="0.01" name="amount" value="{{ $item->amount }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_percentage" value="1" {{ $item->is_percentage ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-900">Amount is a percentage (%)</span>
                        </label>
                        <div class="flex gap-2">
                            <button type="submit" class="text-sm text-green-600 font-medium">Save</button>
                            <button type="button" @click="editId = null" class="text-sm text-gray-600 font-medium">Cancel</button>
                        </div>
                    </form>
                @empty
                    <p class="text-sm text-gray-500">No discounts created yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Fines List -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Fines</h2>
            <div class="space-y-2">
                @forelse($fines as $item)
                    <!-- Display Row -->
                    <div x-show="editId !== {{ $item->id }}" class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-medium text-gray-900">{{ $item->name }}</span>
                            <span class="text-sm text-gray-600 ml-2">({{ $item->is_percentage ? $item->amount.'%' : '$'.number_format($item->amount, 2) }})</span>
                        </div>
                        <div>
                            <button @click="editId = {{ $item->id }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                            <form action="{{ route('school-superadmin.fee-adjustments.destroy', $item) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                    <!-- Edit Form -->
                    <form x-show="editId === {{ $item->id }}" action="{{ route('school-superadmin.fee-adjustments.update', $item) }}" method="POST" class="p-3 bg-blue-50 rounded-lg space-y-3">
                        @csrf @method('PUT')
                        <input type="hidden" name="type" value="fine">
                        <input type="text" name="name" value="{{ $item->name }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                        <input type="number" step="0.01" name="amount" value="{{ $item->amount }}" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" required>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_percentage" value="1" {{ $item->is_percentage ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-900">Amount is a percentage (%)</span>
                        </label>
                        <div class="flex gap-2">
                            <button type="submit" class="text-sm text-green-600 font-medium">Save</button>
                            <button type="button" @click="editId = null" class="text-sm text-gray-600 font-medium">Cancel</button>
                        </div>
                    </form>
                @empty
                    <p class="text-sm text-gray-500">No fines created yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection