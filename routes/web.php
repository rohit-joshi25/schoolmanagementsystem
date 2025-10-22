<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\ImpersonateController;
use App\Http\Controllers\SuperAdmin\BranchController;
use App\Http\Controllers\SuperAdmin\SchoolSubscriptionController;
use App\Http\Controllers\SuperAdmin\PaymentGatewayController;
use App\Http\Controllers\SuperAdmin\PaymentLogController;
use App\Http\Controllers\SuperAdmin\EarningsController;


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
