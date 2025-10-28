@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-10 mt-10">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            {{-- This title will correctly say "Add New Expense" --}}
            <h1 class="text-3xl font-bold text-gray-800">Add New {{ ucfirst($type) }}</h1>
        </div>

        {{-- Form --}}
        <form action="{{ route('school-superadmin.transactions.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            {{-- Branch & Category --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Branch --}}
                <div>
                    <label for="branch_id" class="block text-sm font-semibold text-gray-700 mb-2">Branch *</label>
                    <select name="branch_id" id="branch_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        <option value="">-- Select Branch --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="income_expense_category_id"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ ucfirst($type) }} Category *</label>
                    <select name="income_expense_category_id" id="income_expense_category_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('income_expense_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('income_expense_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Title & Amount --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">{{ ucfirst($type) }} Title
                        *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                        placeholder="e.g., January Staff Salaries">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Amount --}}
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount *</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                        placeholder="0.00">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Transaction Date --}}
            <div>
                <label for="transaction_date" class="block text-sm font-semibold text-gray-700 mb-2">Transaction Date
                    *</label>
                <input type="date" name="transaction_date" id="transaction_date"
                    value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                @error('transaction_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description
                    (Optional)</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                    placeholder="Add transaction notes if needed...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Upload --}}
            <div>
                <label for="file_path" class="block text-sm font-semibold text-gray-700 mb-2">Attach Receipt
                    (Optional)</label>
                <input type="file" name="file_path" id="file_path"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                            file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('file_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-6 border-t text-right">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                    Save {{ ucfirst($type) }}
                </button>
            </div>
        </form>
    </div>
@endsection
