@extends('layouts.school-superadmin')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Income/Expense Report</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500">Total Income</h3>
                <p class="mt-2 text-3xl font-semibold text-green-600">${{ number_format($totalIncome, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500">Total Expense</h3>
                <p class="mt-2 text-3xl font-semibold text-red-600">${{ number_format($totalExpense, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500">Net Profit / Loss</h3>
                <p class="mt-2 text-3xl font-semibold {{ $netProfit >= 0 ? 'text-gray-900' : 'text-red-700' }}">
                    ${{ number_format($netProfit, 2) }}
                </p>
            </div>
        </div>

        <!-- Transaction Log -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">Transaction History</h2>
                <form method="GET" action="{{ route('school-superadmin.transactions.index') }}" class="flex gap-4">
                    <select name="type" class="block rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                        <option value="">All Transactions</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income Only</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense Only</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($transactions as $tx)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $tx->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tx->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M, Y') }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $tx->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->type == 'income' ? '+' : '-' }}${{ number_format($tx->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('school-superadmin.transactions.destroy', $tx) }}"
                                        method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
