<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;
use App\Models\Repayment;
class BorrowerDashboardController extends Controller
{

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $transactions = $this->getTransactions($user);
        $activeLoans = $this->getActiveLoans($user);
        $chartData = $this->getFinancialHealthData($user);

        return view('borrower.dashboard', array_merge([
            'wallet' => $user->wallet,
            'transactions' => $transactions,
            'totalTransactionAmount' => $activeLoans->sum('amount'),
            'totalTransactionCount' => $transactions->count(),
            'currentLoan' => $activeLoans->first(),
        ], $chartData));
    }

    private function getTransactions($user)
    {
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

        return $disbursements->concat($repayments)->sortByDesc('date')->values();
    }

    private function getActiveLoans($user)
    {
        return $user->loans()
            ->whereIn('status', ['disbursed', 'approved'])
            ->where('remaining_balance', '>', 0)
            ->get();
    }

    private function getFinancialHealthData($user)
    {
        // 3. Financial Health Chart Data (Last 6 Months)
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        // Fetch monthly aggregated repayment data
        // Use PostgreSQL-compatible date formatting
        $monthlyRepayments = DB::table('repayments')
            ->join('loans', 'repayments.loan_id', '=', 'loans.id')
            ->where('loans.borrower_id', $user->id)
            ->where('repayments.paid_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw("TO_CHAR(repayments.paid_at, 'YYYY-MM') as month"),
                DB::raw('SUM(repayments.amount) as total')
            )
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $chartLabels = [];
        $chartData = [];

        // Generate last 6 months list and fill data
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');

            $chartLabels[] = $date->format('M');
            $chartData[] = isset($monthlyRepayments[$monthKey]) ? (float) $monthlyRepayments[$monthKey] : 0;
        }

        return [
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ];
    }
}
