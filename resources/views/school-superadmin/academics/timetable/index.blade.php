@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto"
     x-data="timetableSelector()">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Select Class Timetable</h1>

    <div class="space-y-4">
        {{-- Branch Selector --}}
        <div>
            <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
            <select id="branch_id" x-model="selectedBranchId" @change="loadClasses()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Select Branch --</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Class Selector --}}
        <div x-show="selectedBranchId && classes.length > 0">
            <label for="class_id" class="block text-sm font-medium text-gray-700">Class</label>
            <select id="class_id" x-model="selectedClassId" @change="loadSections()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Select Class --</option>
                <template x-for="cls in classes" :key="cls.id">
                    <option :value="cls.id" x-text="cls.name"></option>
                </template>
            </select>
        </div>
        <div x-show="selectedBranchId && classes.length === 0" class="text-sm text-gray-500">
            No classes found for the selected branch. Please add classes first.
        </div>

        {{-- Section Selector --}}
        <div x-show="selectedClassId && sections.length > 0">
            <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
            <select id="section_id" x-model="selectedSectionId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Select Section --</option>
                 <template x-for="sec in sections" :key="sec.id">
                    <option :value="sec.id" x-text="sec.name"></option>
                </template>
            </select>
        </div>
         <div x-show="selectedClassId && sections.length === 0 && classes.length > 0" class="text-sm text-gray-500">
            No sections found for the selected class. Please add sections first.
        </div>

    </div>

    <div class="mt-6 border-t pt-6 flex justify-end">
        <button type="button" @click="viewTimetable()" :disabled="!selectedSectionId"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 disabled:opacity-50">
            View/Manage Timetable
        </button>
    </div>
</div>

@push('scripts')
<script>
    function timetableSelector() {
        return {
            branches: @json($branches),
            selectedBranchId: '',
            selectedClassId: '',
            selectedSectionId: '',
            classes: [],
            sections: [],

            loadClasses() {
                this.selectedClassId = '';
                this.selectedSectionId = '';
                this.sections = [];
                if (!this.selectedBranchId) {
                    this.classes = [];
                    return;
                }
                const selectedBranch = this.branches.find(b => b.id == this.selectedBranchId);
                this.classes = selectedBranch ? selectedBranch.classes : [];
            },

            loadSections() {
                 this.selectedSectionId = '';
                 if (!this.selectedClassId) {
                    this.sections = [];
                    return;
                 }
                 const selectedClass = this.classes.find(c => c.id == this.selectedClassId);
                 this.sections = selectedClass ? selectedClass.sections : [];
            },
            
            viewTimetable() {
                if(this.selectedSectionId) {
                    // Build the URL using the selected section ID
                    let url = "{{ route('school-superadmin.timetable.show', ['section' => ':id']) }}";
                    url = url.replace(':id', this.selectedSectionId);
                    window.location.href = url;
                }
            }
        }
    }
</script>
@endpush
@endsection