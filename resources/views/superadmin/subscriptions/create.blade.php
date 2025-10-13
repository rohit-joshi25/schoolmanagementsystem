@extends('layouts.superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Assign Plan to School</h1>
            <a href="{{ route('superadmin.plans.index') }}" class="text-blue-600 hover:underline">Back to Plan List</a>
        </div>

        @if ($schools->isEmpty())
            <div class="p-4 bg-blue-100 border border-blue-400 text-blue-800 text-sm rounded-md">
                <p><strong>Info:</strong> All active schools already have a subscription plan assigned. There are no schools
                    to select.</p>
            </div>
        @else
            <form action="{{ route('superadmin.subscriptions.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="school_id" class="block text-sm font-medium text-gray-700">Select School</label>
                        <select name="school_id" id="school_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('school_id') border-red-500 @enderror">
                            <option value="">-- Choose a school --</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="plan_id" class="block text-sm font-medium text-gray-700">Select New Plan</label>
                        <select name="plan_id" id="plan_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('plan_id') border-red-500 @enderror">
                            <option value="">-- Choose a plan --</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} (${{ number_format($plan->price, 2) }} / {{ $plan->duration }})
                                </option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">New Subscription Start
                            Date</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Assign Plan
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection
