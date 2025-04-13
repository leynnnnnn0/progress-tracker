<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficeFinalAverageController;
use App\Http\Controllers\OfficeTargetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TargetAccomplishedController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::put('groups/update', [GroupController::class, 'update'])->name('groups.update');

    Route::get('/task-report', [TaskReportController::class, 'index']);
    Route::get('/task-report-download', [TaskReportController::class, 'download'])->name('task-report.download');

    Route::put('/offices-target/update-target-number', [OfficeTargetController::class, 'updateTargetNumber'])->name('offices-target.update-target-number');

    Route::get('/target-accomplished-report', [TargetAccomplishedController::class, 'downloadPDF'])->name('target-accomplished-report');


    Route::get('/offices-target-report', [OfficeTargetController::class, 'downloadPDF'])->name('offices-target-report');
    Route::resource('settings', SettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('offices', OfficeController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('targets', TargetController::class);
    Route::resource('user-tasks', UserTaskController::class);
    Route::resource('offices-final-average', OfficeFinalAverageController::class);
    Route::resource('offices-target', OfficeTargetController::class);
    Route::resource('audits', AuditController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('target-accomplished', TargetAccomplishedController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
