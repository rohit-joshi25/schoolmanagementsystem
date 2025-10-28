@extends('layouts.school-superadmin')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Fee Details for: {{ $student->full_name }}</h1>
                    <p class="text-sm text-gray-600">
                        Class: {{ $student->academicClass->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }} |
                        Branch: {{ $student->branch->name ?? 'N/A' }}
                    </p>
                </div>
                <a href="{{ route('school-superadmin.payment-collection.index') }}"
                    class="text-sm text-blue-600 hover:underline">← Back to Search</a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        {{-- Fee Invoices List --}}
        <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ openPaymentForm: null }">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Student Invoices</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount Due</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($student->studentFees as $fee)
                            @php
                                $amountDue = $fee->amount - $fee->amount_paid;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $fee->feeAllocation->feeType->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($fee->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                    ${{ number_format($fee->amount_paid, 2) }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $amountDue > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                    ${{ number_format($amountDue, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($fee->status == 'paid') bg-green-100 text-green-800
                                    @elseif($fee->status == 'partial') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($fee->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if ($fee->status != 'paid')
                                        <button @click="openPaymentForm = {{ $fee->id }}"
                                            class="text-blue-600 hover:text-blue-900">Add Payment</button>
                                    @else
                                        <span class="text-gray-400">Paid in Full</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- Hidden Form for Adding Payment --}}
                            <tr x-show="openPaymentForm === {{ $fee->id }}" x-cloak>
                                <td colspan="7" class="p-4 bg-gray-50">
                                    <form action="{{ route('school-superadmin.payment-collection.store', $fee) }}"
                                        method="POST">
                                        @csrf
                                        <h4 class="text-md font-semibold mb-2">Add Payment for:
                                            {{ $fee->feeAllocation->feeType->name }}</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Amount Due</label>
                                                <span
                                                    class="text-lg font-bold text-red-600">${{ number_format($amountDue, 2) }}</span>
                                            </div>
                                            <div>
                                                <label for="amount-{{ $fee->id }}"
                                                    class="block text-sm font-medium text-gray-700">Payment Amount *</label>
                                                <input type="number" step="0.01" name="amount"
                                                    id="amount-{{ $fee->id }}" max="{{ $amountDue }}" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>
                                            <div>
                                                <label for="payment_method-{{ $fee->id }}"
                                                    class="block text-sm font-medium text-gray-700">Payment Method *</label>
                                                <select name="payment_method" id="payment_method-{{ $fee->id }}"
                                                    required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                                    @foreach ($paymentMethods as $method)
                                                        <option value="{{ $method }}">{{ $method }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="payment_date-{{ $fee->id }}"
                                                    class="block text-sm font-medium text-gray-700">Payment Date *</label>
                                                <input type="date" name="payment_date"
                                                    id="payment_date-{{ $fee->id }}"
                                                    value="{{ now()->format('Y-m-d') }}" required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            </div>
                                            <div class="col-span-full">
                                                <label for="notes-{{ $fee->id }}"
                                                    class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                                <input type="text" name="notes" id="notes-{{ $fee->id }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                                    placeholder="e.g., Transaction ID, Cheque No...">
                                            </div>
                                        </div>
                                        <div class="flex gap-4 mt-4">
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Save
                                                Payment</button>
                                            <button type="button" @click="openPaymentForm = null"
                                                class="text-sm text-gray-600">Cancel</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    fees have been allocated to this student yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
