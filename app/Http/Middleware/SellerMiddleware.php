<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'seller') {
            abort(403, 'Access denied. Sellers only.');
        }

        return $next($request);
    }
}