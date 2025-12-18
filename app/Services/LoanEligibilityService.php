<?php

namespace App\Services;

use App\Models\User;
use App\Models\Loan;

class LoanEligibilityService
{
    /**
     * Maximum total debt allowed per borrower.
     */
    public const MAX_TOTAL_DEBT = 10000;

    /**
     * Maximum number of concurrent active loans.
     */
    public const MAX_ACTIVE_LOANS = 3;

    /**
     * Check if a user is eligible to apply for a new loan.
     *
     * @param User $user
     * @param float|null $requestedAmount The amount for the new loan (optional)
     * @return array
     */
    public function check(User $user, ?float $requestedAmount = null): array
    {
        $totalDebt = $this->getTotalDebt($user);
        $activeLoanCount = $this->getActiveLoanCount($user);
        $hasOverdue = $this->hasOverdueLoans($user);
        $availableCredit = self::MAX_TOTAL_DEBT - $totalDebt;

        $reasons = [];
        $canApply = true;

        // Check 1: Total debt limit
        if ($totalDebt >= self::MAX_TOTAL_DEBT) {
            $canApply = false;
            $reasons[] = 'Maximum debt limit of RM' . number_format(self::MAX_TOTAL_DEBT) . ' reached.';
        }

        // Check 2: Max concurrent loans
        if ($activeLoanCount >= self::MAX_ACTIVE_LOANS) {
            $canApply = false;
            $reasons[] = 'Maximum of ' . self::MAX_ACTIVE_LOANS . ' concurrent active loans reached.';
        }

        // Check 3: No overdue loans
        if ($hasOverdue) {
            $canApply = false;
            $reasons[] = 'You have overdue loan(s). Please settle them before applying for a new loan.';
        }

        // Check 4: Requested amount within available credit (if provided)
        if ($requestedAmount !== null && $requestedAmount > $availableCredit) {
            $canApply = false;
            $reasons[] = 'Requested amount exceeds available credit of RM' . number_format($availableCredit, 2) . '.';
        }

        return [
            'can_apply' => $canApply,
            'total_debt' => $totalDebt,
            'available_credit' => max(0, $availableCredit),
            'active_loan_count' => $activeLoanCount,
            'max_active_loans' => self::MAX_ACTIVE_LOANS,
            'has_overdue' => $hasOverdue,
            'reasons' => $reasons,
        ];
    }

    /**
     * Get the total outstanding debt for a user.
     */
    public function getTotalDebt(User $user): float
    {
        return $user->loans()
            ->whereIn('status', ['approved', 'disbursed'])
            ->sum('remaining_balance');
    }

    /**
     * Get the count of active loans for a user.
     */
    public function getActiveLoanCount(User $user): int
    {
        return $user->loans()
            ->whereIn('status', ['approved', 'disbursed'])
            ->where('remaining_balance', '>', 0)
            ->count();
    }

    /**
     * Check if a user has any overdue loans.
     */
    public function hasOverdueLoans(User $user): bool
    {
        return $user->loans()
            ->where('status', 'disbursed')
            ->where('remaining_balance', '>', 0)
            ->where('due_date', '<', now())
            ->exists();
    }

    /**
     * Get the next payment due date for a user.
     */
    public function getNextPaymentDue(User $user): ?array
    {
        $nextLoan = $user->loans()
            ->where('status', 'disbursed')
            ->where('remaining_balance', '>', 0)
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$nextLoan) {
            return null;
        }

        return [
            'loan_id' => $nextLoan->id,
            'amount' => $nextLoan->remaining_balance,
            'due_date' => $nextLoan->due_date,
            'is_overdue' => $nextLoan->isOverdue(),
        ];
    }
}
