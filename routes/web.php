<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('/users', function () {
    return Inertia::render('Dashboard');
})->name('users.index');

Route::get('/offices', function () {
    return Inertia::render('Dashboard');
})->name('offices.index');

Route::resource('offices', OfficeController::class);
Route::resource('tasks', TaskController::class);

Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
    route::get('/', 'index')->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
