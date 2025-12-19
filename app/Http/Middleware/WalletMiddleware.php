<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Ensures the authenticated borrower has a linked wallet before
     * accessing loan-related routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only target borrowers for the wallet check
        if (auth()->check() && auth()->user()->role === 'borrower' && !auth()->user()->hasWallet()) {
            return redirect()->route('borrower.wallet.setup')
                ->with('warning', 'Please set up your wallet before applying for a loan.');
        }

        return $next($request);
    }
}
