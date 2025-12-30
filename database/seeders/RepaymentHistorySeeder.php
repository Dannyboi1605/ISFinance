<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repayment;
use App\Models\User;
use App\Models\Loan;
use Carbon\Carbon;

class RepaymentHistorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Find any borrower user
        $borrower = User::where('email', 'borrower@example.com')->first();

        if (!$borrower) {
            echo "No borrower found. Please create a borrower user first.\n";
            return;
        }

        echo "Using borrower: {$borrower->name} ({$borrower->email})\n";

        // 2. Find or create an active loan for this user
        $loan = Loan::where('borrower_id', $borrower->id)->first();

        if (!$loan) {
            $loan = Loan::create([
                'borrower_id' => $borrower->id,
                'wallet_id' => $borrower->wallet->id ?? 1, // Ensure wallet exists
                'amount' => 5000,
                'remaining_balance' => 2900,
                'duration_months' => 12,
                'purpose' => 'Business expansion',
                'status' => 'disbursed',
                'disbursed_at' => Carbon::now()->subMonths(6),
            ]);
        }

        // 3. Clear existing repayments for this loan to avoid duplicates
        Repayment::where('loan_id', $loan->id)->delete();

        // 4. Generate fake history for the last 5 months
        $months = [
            ['month' => 5, 'amount' => 450],  // 5 months ago
            ['month' => 4, 'amount' => 600],  // 4 months ago
            ['month' => 3, 'amount' => 300],  // 3 months ago
            ['month' => 2, 'amount' => 550],  // 2 months ago
            ['month' => 1, 'amount' => 200],  // 1 month ago
        ];

        foreach ($months as $item) {
            $paidDate = Carbon::now()->subMonths($item['month']);

            Repayment::create([
                'loan_id' => $loan->id,
                'amount' => $item['amount'],
                'tx_hash' => '0x' . bin2hex(random_bytes(32)), // Generate fake transaction hash
                'block_number' => rand(1000000, 9999999),
                'paid_at' => $paidDate,
                'created_at' => $paidDate,
                'updated_at' => $paidDate,
            ]);
        }

        echo "Successfully created 5 repayment records for loan #{$loan->id}\n";
    }
}