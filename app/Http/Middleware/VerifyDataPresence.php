<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class VerifyDataPresence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->seller == null) {
            return redirect()->route('firstTimeInvoiceDataSeller');
        }

        if ($request->user()->buyer == null) {
            return redirect()->route('firstTimeInvoiceDataBuyer');
        }

        if ($request->user()->price == null) {
            return redirect()->route('firstTimePriceTaxData');
        }

        return $next($request);
    }
}
