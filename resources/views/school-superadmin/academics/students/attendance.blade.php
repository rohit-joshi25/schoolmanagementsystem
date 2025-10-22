@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form to Select Class -->
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="attendanceForm()">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Select Attendance Criteria</h2>
        
        <form method="GET" action="{{ route('school-superadmin.students.attendance.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                    <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selectedData['branch_id'] ?? '' == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                    <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" @change="loadSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Class --</option>
                        <template x-for="cls in classes" :key="cls.id">
                            <option :value="cls.id" x-text="cls.name" :selected="cls.id == '{{ $selectedData['academic_class_id'] ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Section *</label>
                    <select name="section_id" id="section_id" x-model="selectedSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Section --</option>
                        <template x-for="sec in sections" :key="sec.id">
                            <option :value="sec.id" x-text="sec.name" :selected="sec.id == '{{ $selectedData['section_id'] ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
                 <div>
                    <label for="attendance_date" class="block text-sm font-medium text-gray-700">Attendance Date *</label>
                    <input type="date" name="attendance_date" id="attendance_date" value="{{ $selectedData['attendance_date'] ?? now()->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Attendance Sheet -->
    @if(isset($students))
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Mark Attendance</h2>
        
        <form action="{{ route('school-superadmin.students.attendance.store') }}" method="POST">
            @csrf
            {{-- Pass hidden fields back to the controller --}}
            <input type="hidden" name="section_id" value="{{ $selectedData['section_id'] }}">
            <input type="hidden" name="attendance_date" value="{{ $selectedData['attendance_date'] }}">
            
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($students as $student)
                        @php
                            $currentStatus = $attendanceRecords[$student->id] ?? 'present';
                        @endphp
                        <tr>
                            {{-- ** THIS IS THE FIX ** --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="form-radio" {{ $currentStatus == 'present' ? 'checked' : '' }}>
                                        <span class="ml-2">Present</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="form-radio" {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                                        <span class="ml-2">Absent</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="late" class="form-radio" {{ $currentStatus == 'late' ? 'checked' : '' }}>
                                        <span class="ml-2">Late</span>
                                    </label>
                                     <label class="flex items-center">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="half_day" class="form-radio" {{ $currentStatus == 'half_day' ? 'checked' : '' }}>
                                        <span class="ml-2">Half Day</span>
                                    </label>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <input type="text" name="notes[{{ $student->id }}]" class="text-sm block w-full rounded-md border-gray-300 shadow-sm" placeholder="Optional notes...">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No students found in this section.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($students) && !$students->isEmpty())
            <div class="mt-6 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    Save Attendance
                </button>
            </div>
            @endif
        </form>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function attendanceForm() {
        return {
            branches: @json($branches),
            selectedBranchId: '{{ $selectedData['branch_id'] ?? old('branch_id') }}',
            selectedClassId: '{{ $selectedData['academic_class_id'] ?? old('academic_class_id') }}',
            selectedSectionId: '{{ $selectedData['section_id'] ?? old('section_id') }}',
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