@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto" x-data="classForm()">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Class</h1>
    <form action="{{ route('school-superadmin.classes.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Assign to Branch</label>
                <select name="branch_id" id="branch_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Select Branch --</option>
                     @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
                 @error('branch_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Class Name (e.g., Class 1, Class 10)</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sections</label>
                <template x-for="(section, index) in sections" :key="index">
                    <div class="flex items-center mt-2 gap-2">
                        <input type="text" :name="'sections['+index+']'" x-model="section.name" placeholder="e.g., A, B, Blue, Red" required class="block w-full rounded-md border-gray-300 shadow-sm">
                        <button type="button" @click="removeSection(index)" x-show="sections.length > 1" class="text-red-500 hover:text-red-700">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </template>
                <button type="button" @click="addSection()" class="mt-2 text-sm text-blue-600 hover:underline">+ Add Another Section</button>
                 @error('sections') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Class
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function classForm() {
        return {
            sections: [{ name: '' }],
            addSection() {
                this.sections.push({ name: '' });
            },
            removeSection(index) {
                this.sections.splice(index, 1);
            }
        }
    }
</script>
@endpush
@endsection