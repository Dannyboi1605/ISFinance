<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Alternative: Home route (same as dashboard)
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// ROLE-BASED ROUTES
// ========================================

// Borrower Routes - Protected by 'auth' and 'borrower' middleware
Route::middleware(['auth', 'borrower'])->group(function () {
    Route::get('/borrower/dashboard', function () {
        return view('borrower.dashboard');
    })->name('borrower.dashboard');
});

// Admin Routes - Protected by 'auth' and 'admin' middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
