@extends('layouts.superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800">Edit Branch: {{ $branch->name }}</h1>
        <form action="{{ route('superadmin.schools.branches.update', [$school, $branch]) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Form fields similar to creating a branch, pre-filled with $branch->... data --}}
            <div class="mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Update Branch
                </button>
            </div>
        </form>
    </div>
@endsection
