@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Send Email / SMS</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('school-superadmin.communication.send') }}" method="POST">
        @csrf
        <div class="space-y-6">
            
            <!-- Recipient Selection -->
            <div x-data="recipientSelector()" class="space-y-4">
                <label for="recipient_group" class="block text-sm font-medium text-gray-700">Send To *</label>
                <select name="recipient_group" id="recipient_group" x-model="selectedGroup" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Select a Group --</option>
                    @foreach($recipientGroups as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                    <option value="class">-- Select a Specific Class --</option>
                </select>

                <!-- Dynamic Dropdowns for Class/Section -->
                <div x-show="selectedGroup === 'class'" x-collapse class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border rounded-lg bg-gray-50">
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                        <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" :required="selectedGroup === 'class'" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" @change="loadSections()" :required="selectedGroup === 'class'" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Class --</option>
                            <template x-for="cls in classes" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Section (Optional)</label>
                        <select name="section_id" id="section_id" x-model="selectedSectionId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- All Sections in Class --</option>
                            <template x-for="sec in sections" :key="sec.id">
                                <option :value="sec.id" x-text="sec.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Message Details -->
            <div class="mt-6">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject *</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Holiday Announcement">
                @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                <textarea name="message" id="message" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('message') border-red-500 @enderror" placeholder="Write your message here...">{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    Send Message
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function recipientSelector() {
        return {
            selectedGroup: '{{ old('recipient_group', '') }}',
            branches: @json($branches),
            selectedBranchId: '{{ old('branch_id') }}',
            selectedClassId: '{{ old('academic_class_id') }}',
            selectedSectionId: '{{ old('section_id') }}',
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

                // After loading classes, set the old class ID if it's still valid
                if (isInit) {
                    if (!this.classes.find(c => c.id == this.selectedClassId)) {
                        this.selectedClassId = '';
                    }
                }
            },
            
            loadSections(isInit = false) {
                 if (!isInit) this.selectedSectionId = '';
                 if (!this.selectedClassId) { this.sections = []; return; }
                 
                 const cls = this.classes.find(c => c.id == this.selectedClassId);
                 this.sections = cls ? cls.sections : [];

                 // After loading sections, set the old section ID if it's still valid
                 if (isInit) {
                    if (!this.sections.find(s => s.id == this.selectedSectionId)) {
                        this.selectedSectionId = '';
                    }
                 }
            }
        }
    }
</script>
@endpush
@endsection