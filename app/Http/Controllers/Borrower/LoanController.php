<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Services\LoanEligibilityService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LoanController extends Controller
{
    protected LoanEligibilityService $eligibilityService;

    public function __construct(LoanEligibilityService $eligibilityService)
    {
        $this->eligibilityService = $eligibilityService;
    }

    /**
     * Display a listing of the user's loans.
     */
    public function index(): View
    {
        $user = auth()->user();
        $eligibility = $this->eligibilityService->check($user);

        $loans = $user->loans()
            ->with('repayments')
            ->orderByDesc('created_at')
            ->get();

        return view('borrower.loans.index', [
            'loans' => $loans,
            'eligibility' => $eligibility,
        ]);
    }

    /**
     * Show the form for creating a new loan application.
     */
    public function create(): View|RedirectResponse
    {
        $user = auth()->user();
        $eligibility = $this->eligibilityService->check($user);

        // Block if not eligible
        if (!$eligibility['can_apply']) {
            return redirect()->route('borrower.loans.index')
                ->with('error', implode(' ', $eligibility['reasons']));
        }

        return view('borrower.loans.create', [
            'eligibility' => $eligibility,
            'loanAmounts' => [500, 1000, 2000, 3000, 5000, 10000],
            'durations' => [3, 6, 12, 18, 24],
        ]);
    }

    /**
     * Store a newly created loan application.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $request->validate([
            'amount' => ['required', 'numeric', 'min:500', 'max:10000'],
            'duration_months' => ['required', 'integer', 'in:3,6,12,18,24'],
            'purpose' => ['required', 'string', 'max:500'],
        ]);

        $amount = (float) $request->input('amount');

        // Validate eligibility with requested amount
        $eligibility = $this->eligibilityService->check($user, $amount);

        if (!$eligibility['can_apply']) {
            return redirect()->route('borrower.loans.create')
                ->with('error', implode(' ', $eligibility['reasons']))
                ->withInput();
        }

        // Create the loan application
        Loan::create([
            'borrower_id' => $user->id,
            'wallet_id' => $user->wallet->id,
            'amount' => $amount,
            'remaining_balance' => $amount,
            'duration_months' => $request->input('duration_months'),
            'purpose' => $request->input('purpose'),
            'status' => 'pending',
        ]);

        return redirect()->route('borrower.loans.index')
            ->with('success', 'Your loan application has been submitted successfully!');
    }

    /**
     * Display the specified loan.
     */
    public function show(Loan $loan): View|RedirectResponse
    {
        $user = auth()->user();

        // Ensure user can only view their own loans
        if ($loan->borrower_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('borrower.loans.show', [
            'loan' => $loan->load('repayments', 'wallet'),
        ]);
    }
}
