@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">New Teacher Appraisal</h1>
    
    <form action="{{ route('school-superadmin.performance.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <!-- Main Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Select Teacher *</label>
                    <select name="teacher_id" id="teacher_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('teacher_id') border-red-500 @enderror">
                        <option value="">-- Select a teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="appraisal_date" class="block text-sm font-medium text-gray-700">Appraisal Date *</label>
                    <input type="date" name="appraisal_date" id="appraisal_date" value="{{ old('appraisal_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('appraisal_date') border-red-500 @enderror">
                    @error('appraisal_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Ratings Section -->
            <div class="space-y-4 pt-4 border-t">
                <h3 class="text-lg font-medium text-gray-900">Performance Ratings</h3>
                @if($categories->isEmpty())
                    <p class="text-sm text-gray-500">You must <a href="{{ route('school-superadmin.performance.index') }}" class="text-blue-600 underline">create performance categories</a> before you can add an appraisal.</p>
                @else
                    @foreach($categories as $category)
                        <div class="p-4 border rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ $category->name }} *</label>
                            
                            <!-- 1-5 Rating Radio Buttons -->
                            <div class="flex space-x-4 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="flex items-center">
                                    <input type="radio" name="ratings[{{ $category->id }}][rating]" value="{{ $i }}" class="form-radio" {{ old('ratings.'.$category->id.'.rating') == $i ? 'checked' : '' }}>
                                    <span class="ml-1">{{ $i }}</span>
                                </label>
                                @endfor
                            </div>
                            @error('ratings.'.$category->id.'.rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                            <!-- Comments for this category -->
                            <div class="mt-2">
                                <label for="comments-{{$category->id}}" class="sr-only">Comments for {{ $category->name }}</label>
                                <textarea name="ratings[{{ $category->id }}][comments]" id="comments-{{$category->id}}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Comments (Optional)...">{{ old('ratings.'.$category->id.'.comments') }}</textarea>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Overall Comments -->
            <div>
                <label for="overall_comments" class="block text-sm font-medium text-gray-700">Overall Comments / Summary</label>
                <textarea name="overall_comments" id="overall_comments" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('overall_comments') }}</textarea>
            </div>
        </div>
        
        @if(!$categories->isEmpty())
        <div class="mt-6 border-t pt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Appraisal
            </button>
        </div>
        @endif
    </form>
</div>
@endsection