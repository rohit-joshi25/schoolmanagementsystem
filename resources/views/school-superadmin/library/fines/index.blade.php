@extends('layouts.school-superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Library Fines</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('school-superadmin.library-fines.index') }}" class="mb-6 flex gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days Overdue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Fine</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($fines as $fine)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $fine->student->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $fine->bookIssue->book->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fine->days_overdue }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                                ${{ number_format($fine->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if ($fine->status == 'paid') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($fine->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if ($fine->status == 'pending')
                                    <form action="{{ route('school-superadmin.library-fines.pay', $fine) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Mark this fine as paid?');">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Mark as
                                            Paid</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">Paid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                fines found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
