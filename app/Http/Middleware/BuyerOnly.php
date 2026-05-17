<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BuyerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'buyer') {
            abort(403, 'এই page শুধুমাত্র Buyer দের জন্য।');
        }

        return $next($request);
    }
}