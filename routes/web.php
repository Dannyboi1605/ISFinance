<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Borrower\WalletController;
use App\Http\Controllers\Borrower\LoanController;
use App\Http\Controllers\Borrower\RepaymentController;
use App\Http\Controllers\Admin\AdminLoanController;
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
// BORROWER ROUTES
// ========================================

Route::middleware(['auth', 'borrower'])->prefix('borrower')->name('borrower.')->group(function () {
    // Dashboard
    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // 1. Transaction Simulation & Merging
        $disbursements = $user->loans()
            ->whereNotNull('disbursed_at')
            ->get()
            ->map(function ($loan) {
                return [
                    'type' => 'Disbursement',
                    'loan_id' => $loan->id,
                    'amount' => $loan->amount,
                    'date' => $loan->disbursed_at,
                    'hash' => $loan->contract_address ?? '0xPending...',
                    'status' => 'Successful'
                ];
            });

        $repayments = $user->loans()
            ->with('repayments')
            ->get()
            ->pluck('repayments')
            ->flatten()
            ->map(function ($repayment) {
                return [
                    'type' => 'Repayment',
                    'loan_id' => $repayment->loan_id,
                    'amount' => -$repayment->amount,
                    'date' => $repayment->paid_at,
                    'hash' => $repayment->tx_hash,
                    'status' => 'Successful'
                ];
            });

        $transactions = $disbursements->concat($repayments)->sortByDesc('date')->values();

        // 2. Statistics
        $totalTransactionAmount = $transactions->sum(fn($tx) => abs($tx['amount']));
        $totalTransactionCount = $transactions->count();

        // 3. Active Loan for Progress
        $currentLoan = $user->loans()
            ->whereIn('status', ['disbursed', 'approved'])
            ->where('remaining_balance', '>', 0)
            ->first();

        return view('borrower.dashboard', [
            'wallet' => $user->wallet,
            'transactions' => $transactions,
            'totalTransactionAmount' => $totalTransactionAmount,
            'totalTransactionCount' => $totalTransactionCount,
            'currentLoan' => $currentLoan,
        ]);
    })->name('dashboard');

    // Wallet Setup (no wallet middleware here)
    Route::get('/wallet/setup', [WalletController::class, 'setup'])->name('wallet.setup');
    Route::post('/wallet', [WalletController::class, 'store'])->name('wallet.store');

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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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
});

require __DIR__ . '/auth.php';

