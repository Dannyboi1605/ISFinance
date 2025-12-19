<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Traits\SimulationTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminLoanController extends Controller
{
    use SimulationTrait;

    /**
     * Display a listing of all loans for admin review.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $loans = Loan::with(['borrower', 'wallet'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        $stats = [
            'pending' => Loan::pending()->count(),
            'approved' => Loan::where('status', 'approved')->count(),
            'disbursed' => Loan::disbursed()->count(),
            'completed' => Loan::where('status', 'completed')->count(),
            'rejected' => Loan::where('status', 'rejected')->count(),
        ];

        return view('admin.loans.index', [
            'loans' => $loans,
            'stats' => $stats,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Display the specified loan for detailed review.
     */
    public function show(Loan $loan): View
    {
        return view('admin.loans.show', [
            'loan' => $loan->load(['borrower', 'wallet', 'repayments']),
        ]);
    }

    /**
     * Approve a pending loan application.
     */
    public function approve(Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'pending') {
            return redirect()->route('admin.loans.show', $loan)
                ->with('error', 'Only pending loans can be approved.');
        }

        $loan->update([
            'status' => 'approved',
        ]);

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Loan application has been approved. Ready for disbursement.');
    }

    /**
     * Reject a pending loan application.
     */
    public function reject(Request $request, Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'pending') {
            return redirect()->route('admin.loans.show', $loan)
                ->with('error', 'Only pending loans can be rejected.');
        }

        $request->validate([
            'admin_remark' => 'required|string|max:500',
        ]);

        $loan->update([
            'status' => 'rejected',
            'admin_remark' => $request->admin_remark,
        ]);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan application has been rejected.');
    }

    /**
     * Disburse an approved loan (trigger blockchain simulation).
     */
    public function disburse(Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'approved') {
            return redirect()->route('admin.loans.show', $loan)
                ->with('error', 'Only approved loans can be disbursed.');
        }

        // Generate simulated blockchain data
        $contractAddress = $this->generateContractAddress();
        $dueDate = now()->addMonths($loan->duration_months);

        $loan->update([
            'status' => 'disbursed',
            'contract_address' => $contractAddress,
            'disbursed_at' => now(),
            'due_date' => $dueDate,
        ]);

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Loan has been disbursed successfully!')
            ->with('contract_address', $contractAddress);
    }
}
