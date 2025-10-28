@extends('layouts.school-superadmin')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-10" x-data="feeAllocationForm()">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Fee Allocation</h1>
                <a href="{{ route('school-superadmin.fee-allocations.index') }}"
                    class="text-blue-600 hover:underline text-sm">
                    ← Back to Allocations
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('school-superadmin.fee-allocations.update', $feeAllocation) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Branch --}}
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Branch *
                        </label>
                        <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2
                               focus:ring-blue-400 focus:border-blue-500 @error('branch_id') border-red-500 @enderror">
                            <option value="">-- Select Branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ old('branch_id', $feeAllocation->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Class --}}
                    <div>
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Class *
                        </label>
                        <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2
                               focus:ring-blue-400 focus:border-blue-500 @error('academic_class_id') border-red-500 @enderror">
                            <option value="">-- Select Class --</option>
                            <template x-for="cls in classes" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name" :selected="cls.id == selectedClassId">
                                </option>
                            </template>
                        </select>
                        @error('academic_class_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fee Type --}}
                    <div class="md:col-span-2">
                        <label for="fee_type_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Fee Type *
                        </label>
                        <select name="fee_type_id" id="fee_type_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2
                               focus:ring-blue-400 focus:border-blue-500 @error('fee_type_id') border-red-500 @enderror">
                            <option value="">-- Select Fee Type --</option>
                            @foreach ($feeTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('fee_type_id', $feeAllocation->fee_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->feeGroup->name }} - {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('fee_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                            Amount *
                        </label>
                        <input type="number" step="0.01" name="amount" id="amount"
                            value="{{ old('amount', $feeAllocation->amount) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2
                               focus:ring-blue-400 focus:border-blue-500 @error('amount') border-red-500 @enderror"
                            placeholder="e.g., 5000.00">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Due Date *
                        </label>
                        <input type="date" name="due_date" id="due_date"
                            value="{{ old('due_date', $feeAllocation->due_date) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2
                               focus:ring-blue-400 focus:border-blue-500 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700
                           text-white font-medium rounded-lg shadow-md transition-all duration-200">
                        Update Allocation
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Alpine.js --}}
    @push('scripts')
        <script>
            function feeAllocationForm() {
                return {
                    branches: @json($branches),
                    selectedBranchId: '{{ old('branch_id', $feeAllocation->branch_id) }}',
                    selectedClassId: '{{ old('academic_class_id', $feeAllocation->academic_class_id) }}',
                    classes: [],

                    init() {
                        if (this.selectedBranchId) {
                            this.loadClasses(true);
                        }
                    },
                    loadClasses(isInit = false) {
                        if (!isInit) this.selectedClassId = '';
                        if (!this.selectedBranchId) {
                            this.classes = [];
                            return;
                        }
                        const selectedBranch = this.branches.find(b => b.id == this.selectedBranchId);
                        this.classes = selectedBranch ? selectedBranch.classes : [];

                        // Ensure pre-selected class stays set
                        if (!this.classes.find(c => c.id == this.selectedClassId)) {
                            if (!isInit) this.selectedClassId = '';
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
