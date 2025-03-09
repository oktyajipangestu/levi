<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LeaveController::class, 'index'])->name('dashboard');
    Route::post('/leave/approve/{id}', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/leave/reject/{id}', [LeaveController::class, 'reject'])->name('leave.reject');

    Route::resource('leave', LeaveRequestController::class)->only([
        'index','create','store','show'
    ]);
});

Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/user-management/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::get('/user-management/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::delete('/user-management/{id}', [UserManagementController::class, 'delete'])->name('users.destroy');
});

require __DIR__.'/auth.php';
