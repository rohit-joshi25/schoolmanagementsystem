@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Leave Requests</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('school-superadmin.leave-requests.index') }}" class="mb-6 flex gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($leaveRequests as $request)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $request->student->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $request->student->academicClass->name ?? 'N/A' }} - {{ $request->student->section->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($request->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d M, Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 min-w-[200px] whitespace-pre-wrap">{{ $request->reason }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($request->status == 'approved') bg-green-100 text-green-800
                            @elseif($request->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($request->status == 'pending')
                            <form action="{{ route('school-superadmin.leave-requests.update', $request) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                            </form>
                            <form action="{{ route('school-superadmin.leave-requests.update', $request) }}" method="POST" class="inline ml-4">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                            </form>
                        @else
                           <span class="text-gray-400">Processed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No leave requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection