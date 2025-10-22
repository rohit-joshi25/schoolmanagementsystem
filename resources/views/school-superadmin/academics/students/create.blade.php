@extends('layouts.school-superadmin')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Student Admission</h1>

        <form action="{{ route('school-superadmin.students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Academic Details Section -->
            <div class="mb-8" x-data="studentAdmissionForm()">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Academic Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="admission_no" class="block text-sm font-medium text-gray-700">Admission No *</label>
                        <input type="text" name="admission_no" id="admission_no" value="{{ old('admission_no') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('admission_no') border-red-500 @enderror">
                        @error('admission_no') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="roll_number" class="block text-sm font-medium text-gray-700">Roll Number</label>
                        <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                        <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" @change="loadSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Class --</option>
                            <template x-for="cls in classes" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Section *</label>
                        <select name="section_id" id="section_id" x-model="selectedSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Section --</option>
                            <template x-for="sec in sections" :key="sec.id">
                                <option :value="sec.id" x-text="sec.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Student Details Section -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Student Details & Login</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('first_name') border-red-500 @enderror">
                        @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                     <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date Of Birth *</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <input type="text" name="religion" id="religion" value="{{ old('religion') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                     <div>
                        <label for="caste" class="block text-sm font-medium text-gray-700">Caste</label>
                        <input type="text" name="caste" id="caste" value="{{ old('caste') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                     <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-700">Admission Date *</label>
                        <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select</option>
                             @foreach($blood_groups as $group)
                            <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="house" class="block text-sm font-medium text-gray-700">House</label>
                        <select name="house" id="house" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select</option>
                            @foreach($houses as $house)
                            <option value="{{ $house }}" {{ old('house') == $house ? 'selected' : '' }}>{{ $house }}</option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                        <input type="text" name="height" id="height" value="{{ old('height') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 5' 2&quot;">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight</label>
                        <input type="text" name="weight" id="weight" value="{{ old('weight') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 50 kg">
                    </div>
                    <div>
                        <label for="measurement_date" class="block text-sm font-medium text-gray-700">Measurement Date</label>
                        <input type="date" name="measurement_date" id="measurement_date" value="{{ old('measurement_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History</label>
                        <textarea name="medical_history" id="medical_history" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('medical_history') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="student_photo" class="block text-sm font-medium text-gray-700">Student Photo (100px X 100px)</label>
                        <input type="file" name="student_photo" id="student_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('student_photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t">
                     <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Student Email (Login ID) *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('password') border-red-500 @enderror">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Parent Guardian Detail Section -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Parent / Guardian Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                        <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="guardian_relation" class="block text-sm font-medium text-gray-700">Guardian Relation</label>
                        <input type="text" name="guardian_relation" id="guardian_relation" value="{{ old('guardian_relation') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Father, Mother">
                    </div>
                    <div>
                        <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                        <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="guardian_email" class="block text-sm font-medium text-gray-700">Guardian Email</label>
                        <input type="email" name="guardian_email" id="guardian_email" value="{{ old('guardian_email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-8 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    💾 Admit Student
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function studentAdmissionForm() {
        return {
            branches: @json($branches),
            selectedBranchId: '{{ old('branch_id') }}',
            selectedClassId: '{{ old('academic_class_id') }}',
            selectedSectionId: '{{ old('section_id') }}',
            classes: [],
            sections: [],

            init() {
                this.loadClasses();
                if(this.selectedClassId) {
                    this.loadSections();
                }
            },

            loadClasses() {
                this.sections = [];
                // this.selectedSectionId = ''; // Keep old value if available
                if (!this.selectedBranchId) {
                    this.classes = [];
                    return;
                }
                const selectedBranch = this.branches.find(b => b.id == this.selectedBranchId);
                this.classes = selectedBranch ? selectedBranch.classes : [];
                // If old class ID is not in the new list, clear it
                if (!this.classes.find(c => c.id == this.selectedClassId)) {
                    this.selectedClassId = '';
                }
            },

            loadSections() {
                 if (!this.selectedClassId) {
                    this.sections = [];
                    return;
                 }
                 const selectedClass = this.classes.find(c => c.id == this.selectedClassId);
                 this.sections = selectedClass ? selectedClass.sections : [];
                 if (!this.sections.find(s => s.id == this.selectedSectionId)) {
                    this.selectedSectionId = '';
                 }
            }
        }
    }
</script>
@endpush
@endsection