<?php

use Illuminate\Support\Facades\Route;

//Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\ImpersonateController;
use App\Http\Controllers\SuperAdmin\BranchController;
use App\Http\Controllers\SuperAdmin\SchoolSubscriptionController;
use App\Http\Controllers\SuperAdmin\PaymentGatewayController;
use App\Http\Controllers\SuperAdmin\PaymentLogController;
use App\Http\Controllers\SuperAdmin\EarningsController;
use App\Http\Controllers\SuperAdmin\InvoiceController;


//School Super Admin Controllers
use App\Http\Controllers\SchoolSuperAdmin\DashboardController as SchoolSuperAdminDashboardController;
use App\Http\Controllers\SchoolSuperAdmin\SettingsController;
use App\Http\Controllers\SchoolSuperAdmin\BranchController as SchoolSuperAdminBranchController;
use App\Http\Controllers\SchoolSuperAdmin\StaffController as SchoolSuperAdminStaffController;
use App\Http\Controllers\SchoolSuperAdmin\AcademicClassController;
use App\Http\Controllers\SchoolSuperAdmin\SubjectController as SchoolSuperAdminSubjectController;
use App\Http\Controllers\SchoolSuperAdmin\AssignTeacherController as SchoolSuperAdminAssignTeacherController;
use App\Http\Controllers\SchoolSuperAdmin\TimetableController as SchoolSuperAdminTimetableController;
use App\Http\Controllers\SchoolSuperAdmin\SyllabusController as SchoolSuperAdminSyllabusController;
use App\Http\Controllers\SchoolSuperAdmin\StudentController as SchoolSuperAdminStudentController;
use App\Http\Controllers\SchoolSuperAdmin\StudentPromotionController as SchoolSuperAdminStudentPromotionController;
use App\Http\Controllers\SchoolSuperAdmin\StudentAttendanceController as SchoolSuperAdminStudentAttendanceController;
use App\Http\Controllers\SchoolSuperAdmin\LeaveRequestController as SchoolSuperAdminLeaveRequestController;
use App\Http\Controllers\SchoolSuperAdmin\CertificateController as SchoolSuperAdminCertificateController;
use App\Http\Controllers\SchoolSuperAdmin\TeacherAttendanceController as SchoolSuperAdminTeacherAttendanceController;
use App\Http\Controllers\SchoolSuperAdmin\PayrollController as SchoolSuperAdminPayrollController;
use App\Http\Controllers\SchoolSuperAdmin\SalaryGradeController as SchoolSuperAdminSalaryGradeController;
use App\Http\Controllers\SchoolSuperAdmin\PerformanceCategoryController;
use App\Http\Controllers\SchoolSuperAdmin\TeacherAppraisalController;
use App\Http\Controllers\SchoolSuperAdmin\ParentController as SchoolSuperAdminParentController;
use App\Http\Controllers\SchoolSuperAdmin\FeeGroupController as SchoolSuperAdminFeeGroupController;
use App\Http\Controllers\SchoolSuperAdmin\FeeTypeController as SchoolSuperAdminFeeTypeController;
use App\Http\Controllers\SchoolSuperAdmin\FeeAllocationController as SchoolSuperAdminFeeAllocationController;
use App\Http\Controllers\SchoolSuperAdmin\PaymentCollectionController as SchoolSuperAdminPaymentCollectionController;
use App\Http\Controllers\SchoolSuperAdmin\FeeAdjustmentController as SchoolSuperAdminFeeAdjustmentController;
use App\Http\Controllers\SchoolSuperAdmin\FeeReportController as SchoolSuperAdminFeeReportController;
use App\Http\Controllers\SchoolSuperAdmin\IncomeExpenseCategoryController as SchoolSuperAdminIncomeExpenseCategoryController;
use App\Http\Controllers\SchoolSuperAdmin\TransactionController as SchoolSuperAdminTransactionController;
use App\Http\Controllers\SchoolSuperAdmin\BookController as SchoolSuperAdminBookController;
use App\Http\Controllers\SchoolSuperAdmin\BookIssueController as SchoolSuperAdminBookIssueController;
use App\Http\Controllers\SchoolSuperAdmin\LibraryFineController as SchoolSuperAdminLibraryFineController;
use App\Http\Controllers\SchoolSuperAdmin\GradeSystemController as SchoolSuperAdminGradeSystemController;
use App\Http\Controllers\SchoolSuperAdmin\ExamController as SchoolSuperAdminExamController;
use App\Http\Controllers\SchoolSuperAdmin\MarksEntryController as SchoolSuperAdminMarksEntryController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Super Admin Routes
Route::middleware(['auth', 'is_superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Impersonate Route
    Route::get('schools/{school}/impersonate', [ImpersonateController::class, 'start'])->name('schools.impersonate');

    // ** ADD THIS NESTED ROUTE FOR BRANCHES **
    Route::resource('schools.branches', BranchController::class)->except(['show']);

    // Schools Management Resourceful Route
    Route::resource('schools', SchoolController::class);

    // Subscription Plans Routes
    Route::resource('plans', PlanController::class)->except(['show']);

    Route::resource('schools.branches', BranchController::class)->except(['show']);
    Route::resource('schools', SchoolController::class);

     // Assign Plan Routes
    Route::get('subscriptions/create', [SchoolSubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('subscriptions', [SchoolSubscriptionController::class, 'store'])->name('subscriptions.store');

    // Upgrade/Downgrade Plan Routes
    Route::get('subscriptions/change', [SchoolSubscriptionController::class, 'change'])->name('subscriptions.change');
    Route::post('subscriptions/update', [SchoolSubscriptionController::class, 'update'])->name('subscriptions.update');

     // Subscription History Route
    Route::get('subscriptions/history', [SchoolSubscriptionController::class, 'history'])->name('subscriptions.history');

    // Invoices Route
    Route::get('invoices', [\App\Http\Controllers\SuperAdmin\InvoiceController::class, 'index'])->name('invoices.index');

    //Payment Gateway Routes
    Route::get('payment-gateways', [PaymentGatewayController::class, 'index'])->name('gateways.index');
    Route::post('payment-gateways', [PaymentGatewayController::class, 'update'])->name('gateways.update');

    //Earnings Route
     Route::get('earnings', [EarningsController::class, 'index'])->name('earnings.index');

    //payment log
     Route::get('payment-logs', [PaymentLogController::class, 'index'])->name('payment-logs.index');

});


Route::get('impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop')->middleware('auth');

// School Superadmin Routes
Route::middleware(['auth', 'is_school_superadmin'])->prefix('school-superadmin')->name('school-superadmin.')->group(function () {
    Route::get('dashboard', [SchoolSuperAdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/logo', [SettingsController::class, 'updateLogo'])->name('settings.logo.update');
    //Branch routes
     Route::resource('staff', SchoolSuperAdminStaffController::class);

    Route::resource('branches', SchoolSuperAdminBranchController::class)->except(['show']);

    Route::get('branches/settings', [SchoolSuperAdminBranchController::class, 'settings'])->name('branches.settings');
    //Academic Class Routes
    Route::resource('classes', AcademicClassController::class)->except(['show', 'edit', 'update']);
    Route::resource('subjects', SchoolSuperAdminSubjectController::class)->except(['show']);

    //Teacher Routes
    Route::get('assign-teachers', [SchoolSuperAdminAssignTeacherController::class, 'index'])->name('assign-teachers.index');
    Route::get('assign-teachers/{subject}/edit', [SchoolSuperAdminAssignTeacherController::class, 'edit'])->name('assign-teachers.edit');
    Route::put('assign-teachers/{subject}', [SchoolSuperAdminAssignTeacherController::class, 'update'])->name('assign-teachers.update');

    //timetabe routes
    Route::get('timetable', [SchoolSuperAdminTimetableController::class, 'index'])->name('timetable.index');
    Route::get('timetable/section/{section}', [SchoolSuperAdminTimetableController::class, 'show'])->name('timetable.show');
    Route::post('timetable/section/{section}', [SchoolSuperAdminTimetableController::class, 'store'])->name('timetable.store');
    Route::delete('timetable/{timetable}', [SchoolSuperAdminTimetableController::class, 'destroy'])->name('timetable.destroy');

    // Syllabus
    Route::resource('syllabus', SchoolSuperAdminSyllabusController::class)->only(['index', 'create', 'store', 'destroy']);

    // Students
    Route::resource('students', SchoolSuperAdminStudentController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('student-promotion', [SchoolSuperAdminStudentPromotionController::class, 'index'])->name('students.promotion.index');
    Route::post('student-promotion', [SchoolSuperAdminStudentPromotionController::class, 'promote'])->name('students.promotion.promote');
    Route::get('student-attendance', [SchoolSuperAdminStudentAttendanceController::class, 'index'])->name('students.attendance.index');
    Route::post('student-attendance', [SchoolSuperAdminStudentAttendanceController::class, 'store'])->name('students.attendance.store');


    // Student Leave Requests
    Route::get('leave-requests', [SchoolSuperAdminLeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::post('leave-requests/{leave_request}/update', [SchoolSuperAdminLeaveRequestController::class, 'updateStatus'])->name('leave-requests.update');

    Route::resource('certificates', SchoolSuperAdminCertificateController::class)->except(['show']);

    // Teacher Attendance Routes
    Route::get('teacher-attendance', [SchoolSuperAdminTeacherAttendanceController::class, 'index'])->name('teachers.attendance.index');
    Route::post('teacher-attendance', [SchoolSuperAdminTeacherAttendanceController::class, 'store'])->name('teachers.attendance.store');

    // Payroll Routes
    Route::get('payroll', [SchoolSuperAdminPayrollController::class, 'index'])->name('payroll.index');
    Route::put('payroll/{staff}', [SchoolSuperAdminPayrollController::class, 'update'])->name('payroll.update');

    // Salary Grade Management Routes
    Route::resource('salary-grades', SchoolSuperAdminSalaryGradeController::class)->except(['index', 'show', 'create', 'edit']);

    // Performance Category Management
    Route::resource('performance-categories', PerformanceCategoryController::class)->only([
        'store', 'update', 'destroy'
    ]);

    // Teacher Appraisal (Performance) Routes
    Route::resource('performance', TeacherAppraisalController::class)->only([
        'index', 'create', 'store', 'show'
    ]);

    // Parent Routes
    Route::get('parents', [SchoolSuperAdminParentController::class, 'index'])->name('parents.index');

    //Fees Management
    Route::resource('fee-groups', SchoolSuperAdminFeeGroupController::class)->except(['show']);

    Route::resource('fee-types', SchoolSuperAdminFeeTypeController::class)->except(['show']);

    Route::resource('fee-allocations', SchoolSuperAdminFeeAllocationController::class)->except(['show']);

    // Payment Collection
    Route::get('payment-collection', [SchoolSuperAdminPaymentCollectionController::class, 'index'])->name('payment-collection.index');
    Route::get('payment-collection/student/{student}', [SchoolSuperAdminPaymentCollectionController::class, 'show'])->name('payment-collection.show');
    Route::post('payment-collection/student-fee/{studentFee}', [SchoolSuperAdminPaymentCollectionController::class, 'storePayment'])->name('payment-collection.store');

    Route::resource('fee-adjustments', SchoolSuperAdminFeeAdjustmentController::class)->except(['show', 'create', 'edit']);

    // Fees Report Route
    Route::get('fee-reports', [SchoolSuperAdminFeeReportController::class, 'index'])->name('fee-reports.index');

   Route::get('categories', [SchoolSuperAdminIncomeExpenseCategoryController::class, 'index'])->name('categories.index');
    Route::resource('categories', SchoolSuperAdminIncomeExpenseCategoryController::class)->except(['index', 'show', 'create', 'edit']);
    Route::get('transactions', [SchoolSuperAdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/add-income', [SchoolSuperAdminTransactionController::class, 'createIncome'])->name('transactions.create_income');
    Route::get('transactions/add-expense', [SchoolSuperAdminTransactionController::class, 'createExpense'])->name('transactions.create_expense');
    Route::post('transactions', [SchoolSuperAdminTransactionController::class, 'store'])->name('transactions.store');
    Route::delete('transactions/{transaction}', [SchoolSuperAdminTransactionController::class, 'destroy'])->name('transactions.destroy');

    // Library Routes / Stock Report
    Route::get('stock-report', [SchoolSuperAdminBookController::class, 'stockReport'])->name('books.report');
    Route::resource('books', SchoolSuperAdminBookController::class)->except(['show']);

    Route::get('book-issues', [SchoolSuperAdminBookIssueController::class, 'index'])->name('book-issues.index');
    Route::post('book-issues', [SchoolSuperAdminBookIssueController::class, 'store'])->name('book-issues.store');
    Route::post('book-issues/{bookIssue}/return', [SchoolSuperAdminBookIssueController::class, 'returnBook'])->name('book-issues.return');

    // Library Fine Routes
    Route::get('library-fines', [SchoolSuperAdminLibraryFineController::class, 'index'])->name('library-fines.index');
    Route::post('library-fines/{fine}/pay', [SchoolSuperAdminLibraryFineController::class, 'markAsPaid'])->name('library-fines.pay');

    // Examinations
    Route::resource('grade-systems', SchoolSuperAdminGradeSystemController::class)->except(['show']);
    Route::resource('exams', SchoolSuperAdminExamController::class)->except(['show']);
    Route::get('marks-entry', [SchoolSuperAdminMarksEntryController::class, 'index'])->name('marks-entry.index');
    Route::post('marks-entry', [SchoolSuperAdminMarksEntryController::class, 'store'])->name('marks-entry.store');

});

// Admin Routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () { return view('dashboards.admin'); })->name('dashboard');
});

// Teacher Routes
Route::middleware(['auth', 'is_teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('dashboard', function () { return view('dashboards.teacher'); })->name('dashboard');
});

// Student Routes
Route::middleware(['auth', 'is_student'])->prefix('student')->name('student.')->group(function () {
    Route::get('dashboard', function () { return view('dashboards.student'); })->name('dashboard');
});

// Accountant Routes
Route::middleware(['auth', 'is_accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    Route::get('dashboard', function () { return view('dashboards.accountant'); })->name('dashboard');
});
