@extends('layouts.school-superadmin')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form to Select Students -->
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="promotionForm()">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Select Students to Promote</h2>
        <form method="GET" action="{{ route('school-superadmin.students.promotion.index') }}" class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Select Current Class</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="from_branch_id" class="block text-sm font-medium text-gray-700">From Branch *</label>
                    <select name="from_branch_id" id="from_branch_id" x-model="fromBranchId" @change="loadFromClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('from_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="from_class_id" class="block text-sm font-medium text-gray-700">From Class *</label>
                    <select name="from_class_id" id="from_class_id" x-model="fromClassId" @change="loadFromSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Class --</option>
                        <template x-for="cls in fromClasses" :key="cls.id">
                            <option :value="cls.id" x-text="cls.name" :selected="cls.id == '{{ request('from_class_id') }}'"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label for="from_section_id" class="block text-sm font-medium text-gray-700">From Section *</label>
                    <select name="from_section_id" id="from_section_id" x-model="fromSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Section --</option>
                        <template x-for="sec in fromSections" :key="sec.id">
                            <option :value="sec.id" x-text="sec.name" :selected="sec.id == '{{ request('from_section_id') }}'"></option>
                        </template>
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

    <!-- Results and Promotion Form -->
    @if(isset($students))
    <div class="bg-white p-6 rounded-lg shadow-md" x-data="promotionForm()">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Promote Students to New Class</h2>
        
        <form action="{{ route('school-superadmin.students.promotion.promote') }}" method="POST">
            @csrf
            
            <!-- Target Class Selection -->
            <h3 class="text-lg font-medium text-gray-700">Select New Class</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4 p-4 border rounded-md">
                 <div>
                    <label for="to_branch_id" class="block text-sm font-medium text-gray-700">To Branch *</label>
                    <select name="to_branch_id" id="to_branch_id" x-model="toBranchId" @change="loadToClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="to_class_id" class="block text-sm font-medium text-gray-700">To Class *</label>
                    <select name="to_class_id" id="to_class_id" x-model="toClassId" @change="loadToSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Class --</option>
                         <template x-for="cls in toClasses" :key="cls.id">
                            <option :value="cls.id" x-text="cls.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label for="to_section_id" class="block text-sm font-medium text-gray-700">To Section *</label>
                    <select name="to_section_id" id="to_section_id" x-model="toSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Select Section --</option>
                         <template x-for="sec in toSections" :key="sec.id">
                            <option :value="sec.id" x-text="sec.name"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Student List -->
            <h3 class="text-lg font-medium text-gray-700 mt-6 mb-2">Select Students</h3>
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                <input type="checkbox" @click="toggleAll($event)" class="rounded border-gray-300">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($students as $student)
                        <tr>
                            <td class="p-4">
                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="rounded border-gray-300 student-checkbox">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No students found in the selected section.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 disabled:opacity-50">
                    Promote Selected Students
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function promotionForm() {
        return {
            branches: @json($branches),
            // "From" properties
            fromBranchId: '{{ request('from_branch_id') }}',
            fromClassId: '{{ request('from_class_id') }}',
            fromSectionId: '{{ request('from_section_id') }}',
            fromClasses: [],
            fromSections: [],
            // "To" properties
            toBranchId: '',
            toClassId: '',
            toSectionId: '',
            toClasses: [],
            toSections: [],

            init() {
                if (this.fromBranchId) this.loadFromClasses();
                if (this.fromClassId) this.loadFromSections();
            },

            loadFromClasses() {
                this.fromSections = [];
                if (!this.fromBranchId) { this.fromClasses = []; return; }
                const branch = this.branches.find(b => b.id == this.fromBranchId);
                this.fromClasses = branch ? branch.classes : [];
            },
            loadFromSections() {
                if (!this.fromClassId) { this.fromSections = []; return; }
                const cls = this.fromClasses.find(c => c.id == this.fromClassId);
                this.fromSections = cls ? cls.sections : [];
            },
            loadToClasses() {
                this.toSections = [];
                if (!this.toBranchId) { this.toClasses = []; return; }
                const branch = this.branches.find(b => b.id == this.toBranchId);
                this.toClasses = branch ? branch.classes : [];
            },
            loadToSections() {
                if (!this.toClassId) { this.toSections = []; return; }
                const cls = this.toClasses.find(c => c.id == this.toClassId);
                this.toSections = cls ? cls.sections : [];
            },
            toggleAll(event) {
                document.querySelectorAll('.student-checkbox').forEach(checkbox => {
                    checkbox.checked = event.target.checked;
                });
            }
        }
    }
</script>
@endpush
@endsection