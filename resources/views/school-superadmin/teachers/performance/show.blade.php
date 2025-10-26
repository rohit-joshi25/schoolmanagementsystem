@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Appraisal for: {{ $appraisal->teacher->full_name }}</h1>
            <p class="text-sm text-gray-500">
                Conducted on {{ \Carbon\Carbon::parse($appraisal->appraisal_date)->format('d M, Y') }}
                by {{ $appraisal->appraiser->full_name ?? 'N/A' }}
            </p>
        </div>
        <a href="{{ route('school-superadmin.performance.index') }}" class="text-blue-600 hover:underline">
            ← Back to Appraisal History
        </a>
    </div>

    <div class="space-y-6">
        <!-- Ratings Section -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Detailed Ratings</h3>
            <div class="space-y-4">
                @forelse($appraisal->ratings as $rating)
                    <div class="p-4 border rounded-lg bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">{{ $rating->category->name ?? 'Category not found' }}</span>
                            <span class="text-lg font-bold text-blue-600">{{ $rating->rating }} / 5</span>
                        </div>
                        @if($rating->comments)
                        <p class="text-sm text-gray-600 mt-2 pl-4 border-l-2 border-gray-200">
                            {{ $rating->comments }}
                        </p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No individual ratings were recorded for this appraisal.</p>
                @endforelse
            </div>
        </div>

        <!-- Overall Comments -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Overall Comments</h3>
            @if($appraisal->overall_comments)
                <div class="p-4 border rounded-lg bg-gray-50">
                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $appraisal->overall_comments }}</p>
                </div>
            @else
                <p class="text-sm text-gray-500">No overall comments were provided.</p>
            @endif
        </div>

    </div>
</div>
@endsection