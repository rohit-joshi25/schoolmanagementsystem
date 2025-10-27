@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Fees Reports</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Total Fees Allocated</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">${{ number_format($totalAllocated, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Total Fees Collected</h3>
            <p class="mt-2 text-3xl font-semibold text-green-600">${{ number_format($totalCollected, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Total Fees Due</h3>
            <p class="mt-2 text-3xl font-semibold text-red-600">${{ number_format($totalDue, 2) }}</p>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount Paid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentPayments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->student->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payment->studentFee->feeAllocation->feeType->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">${{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No payment transactions found yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection