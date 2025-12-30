<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Borrower\WalletController;
use App\Http\Controllers\Borrower\LoanController;
use App\Http\Controllers\Borrower\RepaymentController;
use App\Http\Controllers\Admin\AdminLoanController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Role-based Dashboard Redirection
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'borrower') {
        return redirect()->route('borrower.dashboard');
    }

    // Fallback for unknown roles
    abort(403, 'Unauthorized access. Invalid user role.');
})->middleware(['auth', 'verified', 'account_status'])->name('dashboard');

// Alternative: Home route (same as dashboard)
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified', 'account_status'])->name('home');

Route::get('/suspended', function () {
    return view('auth.suspended');
})->name('suspended');

Route::middleware(['auth', 'account_status'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// BORROWER ROUTES
// ========================================

Route::middleware(['auth', 'borrower', 'account_status'])->prefix('borrower')->name('borrower.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Borrower\BorrowerDashboardController::class, 'index'])->name('dashboard');

    // Wallet Setup (no wallet middleware here)
    Route::get('/wallet/setup', [WalletController::class, 'setup'])->name('wallet.setup');
    Route::post('/wallet', [WalletController::class, 'store'])->name('wallet.store');
    Route::post('/wallet/reload', [WalletController::class, 'reload'])->name('wallet.reload');

    // Loan Routes (require wallet)
    Route::middleware('wallet')->group(function () {
        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');

        // Repayments
        Route::get('/loans/{loan}/repay', [RepaymentController::class, 'create'])->name('loans.repay');
        Route::post('/loans/{loan}/repay', [RepaymentController::class, 'store'])->name('loans.repay.store');
    });
});

// ========================================
// ADMIN ROUTES
// ========================================

Route::middleware(['auth', 'admin', 'account_status'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $stats = [
            'pending' => \App\Models\Loan::pending()->count(),
            'approved' => \App\Models\Loan::where('status', 'approved')->count(),
            'disbursed' => \App\Models\Loan::disbursed()->count(),
            'completed' => \App\Models\Loan::where('status', 'completed')->count(),
            'total_users' => \App\Models\User::where('role', 'borrower')->count(),
            'total_disbursed' => \App\Models\Loan::whereIn('status', ['disbursed', 'completed'])->sum('amount'),
        ];
        return view('admin.dashboard', compact('stats'));
    })->name('dashboard');

    // Loan Management
    Route::get('/loans', [AdminLoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/{loan}', [AdminLoanController::class, 'show'])->name('loans.show');
    Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/disburse', [AdminLoanController::class, 'disburse'])->name('loans.disburse');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__ . '/auth.php';

