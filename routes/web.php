<?php

use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard', function () {
        return view('leave.index');
    })->name('dashboard');

    Route::resource('leave', LeaveRequestController::class)->only([
        'index','create','store','show'
    ]);
});

Route::middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/dashboard-supervisor', function () {
        return view('pages.employer.index');
    })->name('employer.dashboard');
});

require __DIR__.'/auth.php';
