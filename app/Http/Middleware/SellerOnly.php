<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'seller') {
            abort(403, 'এই page শুধুমাত্র Seller দের জন্য।');
        }

        return $next($request);
    }
}