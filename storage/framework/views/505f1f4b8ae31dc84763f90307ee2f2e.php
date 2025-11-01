<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Student: <?php echo e($student->full_name); ?></h1>

        <form action="<?php echo e(route('school-superadmin.students.update', $student)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Academic Details Section -->
            <div class="mb-8" x-data="studentAdmissionForm()">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Academic Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="admission_no" class="block text-sm font-medium text-gray-700">Admission No *</label>
                        <input type="text" name="admission_no" id="admission_no" value="<?php echo e(old('admission_no', $student->admission_no)); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm <?php $__errorArgs = ['admission_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                    <div>
                        <label for="roll_number" class="block text-sm font-medium text-gray-700">Roll Number</label>
                        <input type="text" name="roll_number" id="roll_number" value="<?php echo e(old('roll_number', $student->roll_number)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch *</label>
                        <select name="branch_id" id="branch_id" x-model="selectedBranchId" @change="loadClasses()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Branch --</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e($student->branch_id == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="academic_class_id" class="block text-sm font-medium text-gray-700">Class *</label>
                        <select name="academic_class_id" id="academic_class_id" x-model="selectedClassId" @change="loadSections()" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Class --</option>
                            <template x-for="cls in classes" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name" :selected="cls.id == selectedClassId"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-gray-700">Section *</label>
                        <select name="section_id" id="section_id" x-model="selectedSectionId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Section --</option>
                            <template x-for="sec in sections" :key="sec.id">
                                <option :value="sec.id" x-text="sec.name" :selected="sec.id == selectedSectionId"></option>
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
                        <input type="text" name="first_name" id="first_name" value="<?php echo e(old('first_name', $student->first_name)); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name', $student->last_name)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="Male" <?php echo e(old('gender', $student->gender) == 'Male' ? 'selected' : ''); ?>>Male</option>
                            <option value="Female" <?php echo e(old('gender', $student->gender) == 'Female' ? 'selected' : ''); ?>>Female</option>
                            <option value="Other" <?php echo e(old('gender', $student->gender) == 'Other' ? 'selected' : ''); ?>>Other</option>
                        </select>
                    </div>
                     <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date Of Birth *</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo e(old('date_of_birth', $student->date_of_birth)); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e(old('category', $student->category) == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                     <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <input type="text" name="religion" id="religion" value="<?php echo e(old('religion', $student->religion)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                     <div>
                        <label for="caste" class="block text-sm font-medium text-gray-700">Caste</label>
                        <input type="text" name="caste" id="caste" value="<?php echo e(old('caste', $student->caste)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                     <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" value="<?php echo e(old('mobile_number', $student->mobile_number)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-700">Admission Date *</label>
                        <input type="date" name="admission_date" id="admission_date" value="<?php echo e(old('admission_date', $student->admission_date)); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                             <?php $__currentLoopData = $blood_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group); ?>" <?php echo e(old('blood_group', $student->blood_group) == $group ? 'selected' : ''); ?>><?php echo e($group); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="house" class="block text-sm font-medium text-gray-700">House</label>
                        <select name="house" id="house" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($house); ?>" <?php echo e(old('house', $student->house) == $house ? 'selected' : ''); ?>><?php echo e($house); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                     <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                        <input type="text" name="height" id="height" value="<?php echo e(old('height', $student->height)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight</label>
                        <input type="text" name="weight" id="weight" value="<?php echo e(old('weight', $student->weight)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="measurement_date" class="block text-sm font-medium text-gray-700">Measurement Date</label>
                        <input type="date" name="measurement_date" id="measurement_date" value="<?php echo e(old('measurement_date', $student->measurement_date)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History</label>
                        <textarea name="medical_history" id="medical_history" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><?php echo e(old('medical_history', $student->medical_history)); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="student_photo" class="block text-sm font-medium text-gray-700">Update Student Photo</label>
                        <input type="file" name="student_photo" id="student_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <?php if($student->student_photo_path): ?>
                            <p class="text-xs text-gray-500 mt-1">Current: <a href="<?php echo e(asset('storage/' . $student->student_photo_path)); ?>" target="_blank" class="text-blue-600">View Photo</a></p>
                        <?php endif; ?>
                    </div>
                </div>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t">
                     <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Student Email (Login ID) *</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email', $student->email)); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">Leave password fields blank to keep the current password.</p>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Parent Guardian Detail Section -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Parent / Guardian Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="guardian_name" class="block text-sm font-medium text-gray-700">Guardian Name</label>
                        <input type="text" name="guardian_name" id="guardian_name" value="<?php echo e(old('guardian_name', $student->guardian_name)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="guardian_relation" class="block text-sm font-medium text-gray-700">Guardian Relation</label>
                        <input type="text" name="guardian_relation" id="guardian_relation" value="<?php echo e(old('guardian_relation', $student->guardian_relation)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="guardian_phone" class="block text-sm font-medium text-gray-700">Guardian Phone</label>
                        <input type="text" name="guardian_phone" id="guardian_phone" value="<?php echo e(old('guardian_phone', $student->guardian_phone)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="guardian_email" class="block text-sm font-medium text-gray-700">Guardian Email</label>
                        <input type="email" name="guardian_email" id="guardian_email" value="<?php echo e(old('guardian_email', $student->guardian_email)); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700">
                    💾 Update Student
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function studentAdmissionForm() {
        return {
            branches: <?php echo json_encode($branches, 15, 512) ?>,
            selectedBranchId: '<?php echo e(old('branch_id', $student->branch_id)); ?>',
            selectedClassId: '<?php echo e(old('academic_class_id', $student->academic_class_id)); ?>',
            selectedSectionId: '<?php echo e(old('section_id', $student->section_id)); ?>',
            classes: [],
            sections: [],

            init() {
                this.loadClasses(true);
                this.loadSections(true);
            },
            loadClasses(isInit = false) {
                this.sections = [];
                if (!isInit) this.selectedClassId = '';
                if (!isInit) this.selectedSectionId = '';
                
                if (!this.selectedBranchId) { this.classes = []; return; }
                const branch = this.branches.find(b => b.id == this.selectedBranchId);
                this.classes = branch ? branch.classes : [];
                
                if (!isInit) {
                    if (!this.classes.find(c => c.id == this.selectedClassId)) {
                        this.selectedClassId = '';
                    }
                }
            },
            loadSections(isInit = false) {
                 if (!isInit) this.selectedSectionId = '';
                 if (!this.selectedClassId) { this.sections = []; return; }
                 
                 const selectedClass = this.classes.find(c => c.id == this.selectedClassId);
                 this.sections = selectedClass ? selectedClass.sections : [];

                 if (!isInit) {
                    if (!this.sections.find(s => s.id == this.selectedSectionId)) {
                        this.selectedSectionId = '';
                    }
                 }
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.school-superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sms\resources\views/school-superadmin/academics/students/edit.blade.php ENDPATH**/ ?>