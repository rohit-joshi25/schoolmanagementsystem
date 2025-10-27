@extends('layouts.school-superadmin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto" x-data="feeAllocationForm()">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Allocate Fee to Class</h1>
    
    <form action="{{ route('school-superadmin.fee-allocations.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Select Branch --</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('branch_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Select Class --</option>
                    <template x-for="cls in classes" :key="cls.id">
                        <option :value="cls.id" x-text="cls.name"></option>
                    </template>
                </select>
                @error('academic_class_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="fee_type_id" class="block text-sm font-medium text-gray-700">Fee Type *</label>
                <select name="fee_type_id" id="fee_type_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Select Fee Type --</option>
                    @foreach($feeTypes as $type)
                        <option value="{{ $type->id }}" {{ old('fee_type_id') == $type->id ? 'selected' : '' }}>{{ $type->feeGroup->name }} - {{ $type->name }}</option>
                    @endforeach
                </select>
                @error('fee_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('amount') border-red-500 @enderror" placeholder="0.00">
                @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('due_date') border-red-500 @enderror">
                @error('due_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Save Allocation
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function feeAllocationForm() {
        return {
            branches: @json($branches),
            selectedBranchId: '{{ old('branch_id') }}',
            selectedClassId: '{{ old('academic_class_id') }}',
            classes: [],

            init() {
                if (this.selectedBranchId) {
                    this.loadClasses(true);
                }
            },
            loadClasses(isInit = false) {
                if (!isInit) this.selectedClassId = '';
                if (!this.selectedBranchId) { this.classes = []; return; }
                const selectedBranch = this.branches.find(b => b.id == this.selectedBranchId);
                this.classes = selectedBranch ? selectedBranch.classes : [];
            }
        }
    }
</script>
@endpush
@endsection