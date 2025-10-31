@extends('layouts.school-superadmin')

@section('content')
    <div class="space-y-6">

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

        <!-- Form to Select Criteria -->
        <div class="bg-white p-6 rounded-lg shadow-md" x-data="marksEntryForm()">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Select Criteria for Marks Entry</h2>

            <form method="GET" action="{{ route('school-superadmin.marks-entry.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                        <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ ($selected['branch_id'] ?? '') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId"
                            @change="loadSections()" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Class --</option>
                            <template x-for="cls in classes" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name"
                                    :selected="cls.id == '{{ $selected['academic_class_id'] ?? '' }}'"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Section *</label>
                        <select name="section_id" id="section_id" x-model="selectedSectionId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Section --</option>
                            <template x-for="sec in sections" :key="sec.id">
                                <option :value="sec.id" x-text="sec.name"
                                    :selected="sec.id == '{{ $selected['section_id'] ?? '' }}'"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="exam_id" class="block text-sm font-medium text-gray-700">Exam *</label>
                        <select name="exam_id" id="exam_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Exam --</option>
                            @foreach ($exams as $exam)
                                <option value="{{ $exam->id }}"
                                    {{ ($selected['exam_id'] ?? '') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject *</label>
                        <select name="subject_id" id="subject_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Subject --</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ ($selected['subject_id'] ?? '') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Search Students
                    </button>
                </div>
            </form>
        </div>

        <!-- Marks Entry Sheet -->
        @if (isset($students))
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Enter Marks</h2>

                <form action="{{ route('school-superadmin.marks-entry.store') }}" method="POST">
                    @csrf
                    {{-- Pass hidden fields back to the controller --}}
                    <input type="hidden" name="branch_id" value="{{ $selected['branch_id'] }}">
                    <input type="hidden" name="academic_class_id" value="{{ $selected['academic_class_id'] }}">
                    <input type="hidden" name="section_id" value="{{ $selected['section_id'] }}">
                    <input type="hidden" name="exam_id" value="{{ $selected['exam_id'] }}">
                    <input type="hidden" name="subject_id" value="{{ $selected['subject_id'] }}">

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marks
                                        Obtained *</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Marks
                                        *</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comments
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($students as $student)
                                    @php
                                        $currentMark = $existingMarks[$student->id] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $student->full_name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <input type="number" step="0.01"
                                                name="marks[{{ $student->id }}][marks_obtained]"
                                                value="{{ old('marks.' . $student->id . '.marks_obtained', $currentMark) }}"
                                                required class="block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                                placeholder="e.g., 85">
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <input type="number" step="0.01"
                                                name="marks[{{ $student->id }}][total_marks]"
                                                value="{{ old('marks.' . $student->id . '.total_marks', 100) }}" required
                                                class="block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                                placeholder="e.g., 100">
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <input type="text" name="marks[{{ $student->id }}][comments]"
                                                value="{{ old('marks.' . $student->id . '.comments') }}"
                                                class="block w-full rounded-md border-gray-300 shadow-sm text-sm"
                                                placeholder="Optional comments...">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                            students found in this section.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (isset($students) && !$students->isEmpty())
                        <div class="mt-6 pt-6 border-t flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                                Save Marks
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function marksEntryForm() {
                return {
                    branches: @json($branches),
                    selectedBranchId: '{{ $selected['branch_id'] ?? old('branch_id') }}',
                    selectedClassId: '{{ $selected['academic_class_id'] ?? old('academic_class_id') }}',
                    selectedSectionId: '{{ $selected['section_id'] ?? old('section_id') }}',
                    classes: [],
                    sections: [],

                    init() {
                        if (this.selectedBranchId) this.loadClasses(true);
                        if (this.selectedClassId) this.loadSections(true);
                    },

                    loadClasses(isInit = false) {
                        this.sections = [];
                        if (!isInit) this.selectedClassId = '';
                        if (!isInit) this.selectedSectionId = '';

                        if (!this.selectedBranchId) {
                            this.classes = [];
                            return;
                        }
                        const branch = this.branches.find(b => b.id == this.selectedBranchId);
                        this.classes = branch ? branch.classes : [];
                    },

                    loadSections(isInit = false) {
                        if (!isInit) this.selectedSectionId = '';
                        if (!this.selectedClassId) {
                            this.sections = [];
                            return;
                        }
                        const cls = this.classes.find(c => c.id == this.selectedClassId);
                        this.sections = cls ? cls.sections : [];
                    }
                }
            }
        </script>
    @endpush
@endsection
