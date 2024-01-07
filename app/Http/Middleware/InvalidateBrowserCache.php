<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvalidateBrowserCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**For some reason this middleware doesnt work as expexted. In dev tools evrythings seems fine:
         * ' Cache-Control:
            max-age=0, must-revalidate, no-store, nocache, private" ' but user still can press 'back' button
            on a browser and see previosuly visited pages which may contain sensitive informations.
            On "https://github.com/inertiajs/inertia/issues/247" there is posted client-side solution to this issue.
            The solution is applied on app.js.
         */

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
