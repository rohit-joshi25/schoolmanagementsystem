<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\ImpersonateController;
use App\Http\Controllers\SuperAdmin\BranchController;
use App\Http\Controllers\SuperAdmin\SchoolSubscriptionController;


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

});


Route::get('impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop')->middleware('auth');

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
