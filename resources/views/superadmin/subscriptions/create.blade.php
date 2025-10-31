@extends('layouts.superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Assign Plan to School</h1>
                <a href="{{ route('superadmin.plans.index') }}" class="text-blue-600 hover:underline">← Back to Plan List</a>
            </div>

            @if ($schools->isEmpty())
                <div class="p-4 bg-blue-100 border border-blue-400 text-blue-800 text-sm rounded-lg">
                    <p><strong>Info:</strong> All active schools already have a subscription plan assigned. There are no
                        schools to select.</p>
                </div>
            @else
                <form action="{{ route('superadmin.subscriptions.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Select School --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Select School --}}
                        <div>
                            <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Select School</label>
                            <select name="school_id" id="school_id" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('school_id') border-red-500 @enderror">
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

                        {{-- Select Plan --}}
                        <div>
                            <label for="plan_id" class="block text-sm font-medium text-gray-700 mb-1">Select New Plan</label>
                            <select name="plan_id" id="plan_id" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('plan_id') border-red-500 @enderror">
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

                        {{-- Start Date --}}
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">New Subscription Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 shadow-sm @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- filler col to keep grid balanced --}}
                        <div></div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                            Assign Plan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
