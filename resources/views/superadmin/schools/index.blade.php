@extends('layouts.superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">School List</h1>
            <a href="{{ route('superadmin.schools.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Add
                New School</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($schools as $school)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $school->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{-- Check if a subscription and plan exist --}}
                                @if ($school->currentSubscription && $school->currentSubscription->plan)
                                    {{ $school->currentSubscription->plan->name }}
                                    ({{ $school->currentSubscription->plan->duration }})
                                @else
                                    <span class="text-gray-400">No Active Plan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($school->currentSubscription)
                                    {{ \Carbon\Carbon::parse($school->currentSubscription->end_date)->format('d M, Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $school->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($school->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('superadmin.schools.branches.index', $school) }}"
                                    class="text-purple-600 hover:text-purple-900">Branches</a>
                                <a href="{{ route('superadmin.schools.impersonate', $school) }}"
                                    class="text-green-600 hover:text-green-900 ml-4">Login</a>
                                <a href="{{ route('superadmin.schools.edit', $school) }}"
                                    class="text-blue-600 hover:text-blue-900 ml-4">Edit</a>
                                <form action="{{ route('superadmin.schools.destroy', $school) }}" method="POST"
                                    class="inline ml-4" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                schools found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
