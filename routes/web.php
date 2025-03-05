<?php

use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OvertimeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login')->name('login');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [LeaveController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('leave')->name('leave.')->group(function () {
        Route::post('/approve/{id}', [LeaveController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [LeaveController::class, 'reject'])->name('reject');
        Route::resource('/', LeaveRequestController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::prefix('overtime')->name('overtime.')->group(function () {
        Route::get('/history', [OvertimeController::class, 'history'])->name('history');
        Route::get('/request', [OvertimeController::class, 'create'])->name('create');
        Route::post('/', [OvertimeController::class, 'store'])->name('store');
        Route::get('/approval', [OvertimeController::class, 'indexApproval'])->name('approval');
        Route::patch('/{id}/status', [OvertimeController::class, 'updateStatus'])->name('updateStatus');
    });

});

Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/dashboard-hr', [LeaveController::class, 'leaveHr'])->name('dashboard.hr');
});

// Memuat rute autentikasi default Laravel
require __DIR__ . '/auth.php';
