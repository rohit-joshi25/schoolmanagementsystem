@extends('layouts.school-superadmin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto" x-data="gradeSystemForm({{ $gradeSystem->gradeDetails->toJson() }})">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Grade System: {{ $gradeSystem->name }}</h1>
            <a href="{{ route('school-superadmin.grade-systems.index') }}" class="text-blue-600 hover:underline">← Back to
                List</a>
        </div>

        <form action="{{ route('school-superadmin.grade-systems.update', $gradeSystem) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Main Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">System Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $gradeSystem->name) }}"
                            required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description
                            (Optional)</label>
                        <input type="text" name="description" id="description"
                            value="{{ old('description', $gradeSystem->description) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                <!-- Grade Details Repeater -->
                <div class="space-y-4 pt-4 border-t">
                    <h3 class="text-lg font-medium text-gray-900">Grade Details</h3>
                    <template x-for="(grade, index) in grades" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center p-4 border rounded-lg">
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Grade Name *</label>
                                <input type="text" :name="'grades[' + index + '][grade_name]'" x-model="grade.grade_name"
                                    required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                    placeholder="e.g., A+">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Mark From (%) *</label>
                                <input type="number" step="0.01" :name="'grades[' + index + '][mark_from]'"
                                    x-model="grade.mark_from" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                    placeholder="e.g., 90">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500">Mark To (%) *</label>
                                <input type="number" step="0.01" :name="'grades[' + index + '][mark_to]'"
                                    x-model="grade.mark_to" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                    placeholder="e.g., 100">
                            </div>
                            <div class="flex items-end h-full">
                                <button type="button" @click="removeGrade(index)" x-show="grades.length > 1"
                                    class="text-red-500 hover:text-red-700 p-2">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                            <div class="col-span-full">
                                <label class="block text-xs font-medium text-gray-500">Comments (Optional)</label>
                                <input type="text" :name="'grades[' + index + '][comments]'" x-model="grade.comments"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                    placeholder="e.g., Excellent">
                            </div>
                        </div>
                    </template>
                    <button type="button" @click="addGrade()" class="mt-2 text-sm text-blue-600 hover:underline">+ Add
                        Another Grade</button>
                    @error('grades')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 border-t pt-6 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Update Grade System
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function gradeSystemForm(existingGrades = []) {
                // Ensure that if old() data is present due to a validation error, we use that instead.
                let oldGrades = @json(old('grades'));
                let initialGrades = oldGrades ? oldGrades.map(g => ({
                    ...g
                })) : (existingGrades.length > 0 ? existingGrades.map(g => ({
                    ...g
                })) : [{
                    grade_name: '',
                    mark_from: '',
                    mark_to: '',
                    comments: ''
                }]);

                return {
                    grades: initialGrades,
                    addGrade() {
                        this.grades.push({
                            grade_name: '',
                            mark_from: '',
                            mark_to: '',
                            comments: ''
                        });
                    },
                    removeGrade(index) {
                        this.grades.splice(index, 1);
                    }
                }
            }
        </script>
    @endpush
@endsection
