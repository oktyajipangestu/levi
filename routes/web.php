<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LeaveController::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Leave (Cuti)
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::post('/approve/{id}', [LeaveController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [LeaveController::class, 'reject'])->name('reject');
        Route::get('/create', [LeaveRequestController::class, 'create'])->name('create');
        Route::post('/store', [LeaveRequestController::class, 'store'])->name('store');
        Route::get('/show/{id}', [LeaveRequestController::class, 'show'])->name('show');
        // Route::resource('/', LeaveRequestController::class)->only(['index', 'create', 'store', 'show']);
    });

    // Overtime (Lembur)
    Route::prefix('overtime')->name('overtime.')->group(function () {
        Route::get('/history', [OvertimeController::class, 'history'])->name('history');
        Route::get('/create', [OvertimeController::class, 'create'])->name('create');
        Route::post('/', [OvertimeController::class, 'store'])->name('store');
        Route::get('/approval', [OvertimeController::class, 'indexApproval'])->name('approval');
        Route::patch('/{id}/status', [OvertimeController::class, 'updateStatus'])->name('updateStatus');
    });

});

Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/user-management/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::get('/user-management/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::delete('/user-management/{id}', [UserManagementController::class, 'delete'])->name('users.destroy');
});

// Memuat rute autentikasi default Laravel
require __DIR__ . '/auth.php';
