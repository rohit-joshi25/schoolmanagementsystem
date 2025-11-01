@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Prepare Transfer Certificate</h1>
    <p class="text-gray-600 mb-6">Review and edit the details below before generating the final PDF.</p>

    <form action="{{ route('school-superadmin.certificates.transfer.download') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Student's Name --}}
                <div>
                    <label for="student_name" class="block text-sm font-medium text-gray-700">Student's Name</label>
                    <input type="text" name="student_name" id="student_name" value="{{ old('student_name', $student->full_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Guardian's Name --}}
                <div>
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian's Name</label>
                    <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Admission Date --}}
                <div>
                    <label for="admission_date" class="block text-sm font-medium text-gray-700">Date of Admission</label>
                    <input type="date" name="admission_date" id="admission_date" value="{{ old('admission_date', \Carbon\Carbon::parse($student->admission_date)->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Class Name --}}
                <div>
                    <label for="class_name" class="block text-sm font-medium text-gray-700">Class</label>
                    <input type="text" name="class_name" id="class_name" value="{{ old('class_name', $student->academicClass->name ?? 'N/A') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Section Name --}}
                <div>
                    <label for="section_name" class="block text-sm font-medium text-gray-700">Section</label>
                    <input type="text" name="section_name" id="section_name" value="{{ old('section_name', $student->section->name ?? 'N/A') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Date of Leaving / Issue Date --}}
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Date of Leaving (Issue Date)</label>
                    <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Character & Conduct --}}
                <div>
                    <label for="character_conduct" class="block text-sm font-medium text-gray-700">Character &amp; Conduct</label>
                    <select name="character_conduct" id="character_conduct" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="Excellent" @if(old('character_conduct', 'Excellent' )=='Excellent' ) selected @endif>Excellent</option>
                        <option value="Good" @if(old('character_conduct', 'Good' )=='Good' ) selected @endif>Good</option>
                        <option value="Satisfactory" @if(old('character_conduct')=='Satisfactory' ) selected @endif>Satisfactory</option>
                        <option value="Needs Improvement" @if(old('character_conduct')=='Needs Improvement' ) selected @endif>Needs Improvement</option>
                    </select>
                </div>

                {{-- Reason for Leaving --}}
                <div>
                    <label for="reason_for_leaving" class="block text-sm font-medium text-gray-700">Reason for Leaving</label>
                    <input type="text" name="reason_for_leaving" id="reason_for_leaving" value="{{ old('reason_for_leaving', "Parent's Request") }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Promotion Status --}}
                <div>
                    <label for="promotion_status" class="block text-sm font-medium text-gray-700">Promotion Status</label>
                    <input type="text" name="promotion_status" id="promotion_status" value="{{ old('promotion_status', 'Promoted to the next class') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            {{-- General Remarks --}}
            <div class="mt-6">
                <label for="general_remarks" class="block text-sm font-medium text-gray-700">General Remarks (Performance)</label>
                <textarea name="general_remarks" id="general_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('general_remarks', 'The student has a good academic record and has shown consistent progress.') }}</textarea>
            </div>

            {{-- Dues Cleared --}}
            <div class="mt-6">
                <label for="dues_cleared" class="block text-sm font-medium text-gray-700">All Dues Cleared</label>
                <input type="text" name="dues_cleared" id="dues_cleared" value="{{ old('dues_cleared', 'Yes, up to date.') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

        </div>

        <div class="mt-8 pt-6 border-t flex justify-end">
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Download PDF
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // This is needed to re-initialize lucide icons on the new page
    lucide.createIcons();
</script>
@endpush