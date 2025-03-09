<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficeFinalAverageController;
use App\Http\Controllers\OfficeTargetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('offices', OfficeController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('targets', TargetController::class);
    Route::resource('user-tasks', UserTaskController::class);
    Route::resource('offices-final-average', OfficeFinalAverageController::class);
    Route::resource('offices-target', OfficeTargetController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
