@extends('layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto px-6 py-10">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Upgrade/Downgrade a School's Plan</h1>
                <a href="{{ route('superadmin.plans.index') }}" class="text-blue-600 hover:underline">← Back to Plan List</a>
            </div>

            @if ($schools->isEmpty())
                <div class="p-4 bg-blue-100 border border-blue-400 text-blue-800 text-sm rounded-lg">
                    <p><strong>Info:</strong> No schools currently have an active subscription plan. You can assign a new
                        plan from the
                        <a href="{{ route('superadmin.subscriptions.create') }}"
                            class="text-blue-700 font-semibold underline hover:text-blue-900">
                            Assign Plan
                        </a>
                        page.
                    </p>
                </div>
            @else
                <form action="{{ route('superadmin.subscriptions.update') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Select School --}}
                    <div>
                        <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Select School (Only schools with active plans are listed)
                        </label>
                        <select name="school_id" id="school_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('school_id') border-red-500 @enderror">
                            <option value="">-- Choose a school --</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                    (Current: {{ $school->currentSubscription->plan->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Select New Plan --}}
                    <div>
                        <label for="plan_id" class="block text-sm font-medium text-gray-700 mb-1">Select New Plan</label>
                        <select name="plan_id" id="plan_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('plan_id') border-red-500 @enderror">
                            <option value="">-- Choose a new plan --</option>
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

                    {{-- New Plan Start Date --}}
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">New Plan Start
                            Date</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                            Change Plan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
