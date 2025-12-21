<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Traits\SimulationTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RepaymentController extends Controller
{
    use SimulationTrait;

    /**
     * Show the repayment form for a specific loan.
     */
    public function create(Loan $loan): View|RedirectResponse
    {
        $user = auth()->user();

        // Ensure user can only repay their own loans
        if ($loan->borrower_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Can only repay disbursed loans with remaining balance
        if ($loan->status !== 'disbursed' || $loan->remaining_balance <= 0) {
            return redirect()->route('borrower.loans.show', $loan)
                ->with('error', 'This loan is not eligible for repayment.');
        }

        return view('borrower.loans.repay', [
            'loan' => $loan,
        ]);
    }

    /**
     * Process a repayment for a specific loan.
     */
    public function store(Request $request, Loan $loan): RedirectResponse
    {
        $user = auth()->user();

        // Ensure user can only repay their own loans
        if ($loan->borrower_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Validate loan is repayable
        if ($loan->status !== 'disbursed' || $loan->remaining_balance <= 0) {
            return redirect()->route('borrower.loans.show', $loan)
                ->with('error', 'This loan is not eligible for repayment.');
        }

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:' . $loan->remaining_balance,
            ],
        ], [
            'amount.max' => 'You cannot repay more than the outstanding balance of RM ' . number_format((float) $loan->remaining_balance, 2),
        ]);

        $amount = (float) $request->input('amount');
        $wallet = $user->wallet;

        // Check wallet balance
        if ($wallet->balance < $amount) {
            return redirect()->back()
                ->withErrors(['amount' => 'Insufficient funds in your ISFinance wallet.'])
                ->withInput();
        }

        // Generate blockchain simulation data
        $simulation = $this->simulateConfirmation();

        // Create the repayment record
        $loan->repayments()->create([
            'amount' => $amount,
            'tx_hash' => $simulation['tx_hash'],
            'block_number' => $simulation['block_number'],
            'paid_at' => now(),
        ]);

        // Deduct from wallet balance
        $wallet->decrement('balance', $amount);

        // Update loan remaining balance
        $newBalance = $loan->remaining_balance - $amount;
        $loan->update([
            'remaining_balance' => $newBalance,
            'status' => $newBalance <= 0 ? 'completed' : 'disbursed',
        ]);

        $message = $newBalance <= 0
            ? 'Congratulations! Your loan has been fully repaid.'
            : 'Payment of RM' . number_format($amount, 2) . ' processed successfully.';

        return redirect()->route('borrower.loans.show', $loan)
            ->with('success', $message)
            ->with('tx_hash', $simulation['tx_hash']);
    }
}
