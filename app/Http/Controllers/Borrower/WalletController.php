<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Traits\SimulationTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WalletController extends Controller
{
    use SimulationTrait;

    /**
     * Display the wallet setup page.
     */
    public function setup(): View
    {
        $user = auth()->user();

        // If user already has a wallet, redirect to dashboard
        if ($user->hasWallet()) {
            return view('borrower.wallet.show', [
                'wallet' => $user->wallet,
            ]);
        }

        return view('borrower.wallet.setup');
    }

    /**
     * Store a newly created wallet.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Prevent duplicate wallet creation
        if ($user->hasWallet()) {
            return redirect()->route('borrower.dashboard')
                ->with('info', 'You already have a linked wallet.');
        }

        $request->validate([
            'type' => ['required', 'in:custodial,non_custodial'],
            'wallet_address' => ['required_if:type,non_custodial', 'nullable', 'string', 'regex:/^0x[a-fA-F0-9]{40}$/'],
        ], [
            'wallet_address.regex' => 'Please enter a valid Ethereum wallet address (0x followed by 40 hex characters).',
        ]);

        $walletType = $request->input('type');

        // For custodial wallets, auto-generate address
        // For non-custodial, use the provided address
        $walletAddress = $walletType === 'custodial'
            ? $this->generateWalletAddress()
            : $request->input('wallet_address');

        $user->wallet()->create([
            'wallet_address' => $walletAddress,
            'type' => $walletType,
            'is_active' => true,
        ]);

        $message = $walletType === 'custodial'
            ? 'Your custodial wallet has been created successfully!'
            : 'Your external wallet has been linked successfully!';

        return redirect()->route('borrower.dashboard')
            ->with('success', $message);
    }
}
