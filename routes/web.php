<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OvertimeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login')->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Grouping route untuk profil pengguna
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Grouping route untuk fitur lembur
    Route::prefix('overtime')->name('overtime.')->group(function () {
        Route::get('/request', [OvertimeController::class, 'create'])->name('create');
        Route::post('/', [OvertimeController::class, 'store'])->name('store');
        Route::get('/approval', [OvertimeController::class, 'indexApproval'])->name('approval');
        Route::patch('/{id}/status', [OvertimeController::class, 'updateStatus'])->name('updateStatus');
    });
});

require __DIR__ . '/auth.php';
