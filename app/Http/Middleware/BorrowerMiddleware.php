<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BorrowerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has borrower role
        if (auth()->check() && auth()->user()->role === 'borrower') {
            return $next($request);
        }

        // Return 403 Forbidden if not authorized
        abort(403, 'Unauthorized access. Borrower role required.');
    }
}
