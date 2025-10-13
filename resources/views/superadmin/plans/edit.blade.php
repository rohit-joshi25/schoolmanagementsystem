@extends('layouts.superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Edit Plan: {{ $plan->name }}</h1>
                <a href="{{ route('superadmin.plans.index') }}" class="text-blue-600 hover:underline">Back to Plan List</a>
            </div>

            {{-- Form --}}
            <form action="{{ route('superadmin.plans.update', $plan) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Plan Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="Enter plan name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="number" step="0.01" name="price" id="price"
                            value="{{ old('price', $plan->price) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('price') border-red-500 @enderror"
                            placeholder="Enter price">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                        <select name="duration" id="duration" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('duration') border-red-500 @enderror">
                            <option value="Monthly" {{ old('duration', $plan->duration) == 'Monthly' ? 'selected' : '' }}>
                                Monthly</option>
                            <option value="Yearly" {{ old('duration', $plan->duration) == 'Yearly' ? 'selected' : '' }}>
                                Yearly</option>
                        </select>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            <option value="active" {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status', $plan->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
