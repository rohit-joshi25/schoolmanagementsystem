

<?php $__env->startSection('content'); ?>
    <div 
        class="p-6 bg-white border border-gray-200 rounded-lg shadow-md"
        
        x-data="{
            allData: <?php echo e(json_encode($branches)); ?>,
            selectedBranchId: '',
            selectedSectionId: '',
            selectedStudentId: '',
            
            availableSections: [],
            availableStudents: [],
            
            isLoadingStudents: false,

            
            onBranchChange(event) {
                this.selectedSectionId = '';
                this.selectedStudentId = '';
                this.availableSections = [];
                this.availableStudents = [];
                
                if (!this.selectedBranchId) return;

                const selectedBranch = this.allData.find(branch => branch.id == this.selectedBranchId);
                
                if (selectedBranch) {
                    let sections = [];
                    selectedBranch.classes.forEach(schoolClass => {
                        schoolClass.sections.forEach(section => {
                            sections.push({ 
                                id: section.id, 
                                name: `${schoolClass.name} - ${section.name}` 
                            });
                        });
                    });
                    this.availableSections = sections;
                }
            },

            
            onSectionChange(event) {
                this.selectedStudentId = '';
                this.availableStudents = [];

                if (!this.selectedSectionId) return;

                this.isLoadingStudents = true;
                
                const url = `<?php echo e(route('school-superadmin.api.students-by-section', ['section' => ':id'])); ?>`.replace(':id', this.selectedSectionId);

                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        this.availableStudents = data;
                        this.isLoadingStudents = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.isLoadingStudents = false;
                    });
            }
        }"
    >
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Generate Transfer Certificate</h2>

        <?php if(session('info')): ?>
            <div class="mb-4 p-4 text-sm text-blue-700 bg-blue-100 rounded-lg" role="alert">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        <p class="text-gray-600 mb-6">
            Select a student to generate a Transfer Certificate (TC).
        </p>

        <form method="GET" :action="selectedStudentId ? '<?php echo e(route('school-superadmin.transfer-certificate.prepare', ['student' => ':id'])); ?>'.replace(':id', selectedStudentId) : '#'" target="_blank" x-ref="generateForm">
            <div classs="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    
                    <div>
                        <label for="branch" class="block text-sm font-medium text-gray-700 mb-1">Select Branch</label>
                        <select 
                            id="branch" 
                            name="branch" 
                            x-model="selectedBranchId"
                            @change="onBranchChange"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">-- Select Branch --</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
                        <select 
                            id="class" 
                            name="section"
                            x-model="selectedSectionId"
                            @change="onSectionChange"
                            :disabled="!selectedBranchId || availableSections.length === 0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-100"
                        >
                            <option value="">-- Select Class --</option>
                            <template x-for="section in availableSections" :key="section.id">
                                <option :value="section.id" x-text="section.name"></option>
                            </template>
                        </select>
                    </div>

                    
                    <div>
                        <label for="student" class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                        <select 
                            id="student" 
                            name="student"
                            x-model="selectedStudentId"
                            :disabled="!selectedSectionId || isLoadingStudents"
                            
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-100 truncate"
                        >
                            
                            <option value="">-- Select Student --</option>
                            
                            <template x-if="isLoadingStudents">
                                <option value="" disabled>Loading students...</option>
                            </template>
                            <template x-for="student in availableStudents" :key="student.id">
                                <option :value="student.id" x-text="`${student.first_name} ${student.last_name} (Roll: ${student.roll_number})`"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button 
                        type="submit" 
                        :disabled="!selectedStudentId"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        Generate Certificate
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.school-superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sms\resources\views/school-superadmin/certificates/transfer-certificate.blade.php ENDPATH**/ ?>