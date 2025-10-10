<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// Import the new controller
use App\Http\Controllers\SuperAdmin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// General home route, often used for default redirection if needed
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Role-based dashboards using organized controllers
Route::middleware(['auth', 'is_superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Add other superadmin routes here in the future
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // You will create an Admin\DashboardController for this later
    Route::get('dashboard', function () {
        return view('dashboards.admin');
    })->name('dashboard');
});

Route::middleware(['auth', 'is_teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // You will create a Teacher\DashboardController for this later
    Route::get('dashboard', function () {
        return view('dashboards.teacher');
    })->name('dashboard');
});

Route::middleware(['auth', 'is_student'])->prefix('student')->name('student.')->group(function () {
    // You will create a Student\DashboardController for this later
    Route::get('dashboard', function () {
        return view('dashboards.student');
    })->name('dashboard');
});

Route::middleware(['auth', 'is_accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    // You will create an Accountant\DashboardController for this later
    Route::get('dashboard', function () {
        return view('dashboards.accountant');
    })->name('dashboard');
});

