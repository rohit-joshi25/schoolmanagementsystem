@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">

    <!-- Form to Select Criteria -->
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="reportCardForm()">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Generate Report Cards</h2>
        
        <form method="GET" action="{{ route('school-superadmin.report-cards.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                    <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selected['branch_id'] ?? '' == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                    <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" @change="loadSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Class --</option>
                        <template x-for="cls in classes" :key="cls.id">
                            <option :value="cls.id" x-text="cls.name" :selected="cls.id == '{{ $selected['academic_class_id'] ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section *</label>
                    <select name="section_id" id="section_id" x-model="selectedSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Section --</option>
                        <template x-for="sec in sections" :key="sec.id">
                            <option :value="sec.id" x-text="sec.name" :selected="sec.id == '{{ $selected['section_id'] ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
                 <div>
                    <label for="exam_id" class="block text-sm font-medium text-gray-700">Exam *</label>
                    <select name="exam_id" id="exam_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Exam --</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ ($selected['exam_id'] ?? '') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Search Students
                </button>
            </div>
        </form>
    </div>

    <!-- Student List -->
    @if(isset($students))
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Student List</h2>
        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admission No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roll Number</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_no }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->roll_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('school-superadmin.report-cards.show', ['exam_id' => $selected['exam_id'], 'student_id' => $student->id]) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-900">
                                Generate Report
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No students found in this section.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function reportCardForm() {
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
                if (!this.selectedBranchId) { this.classes = []; return; }
                const branch = this.branches.find(b => b.id == this.selectedBranchId);
                this.classes = branch ? branch.classes : [];
            },
            loadSections(isInit = false) {
                 if (!isInit) this.selectedSectionId = '';
                 if (!this.selectedClassId) { this.sections = []; return; }
                 const cls = this.classes.find(c => c.id == this.selectedClassId);
                 this.sections = cls ? cls.sections : [];
            }
        }
    }
</script>
@endpush
@endsection