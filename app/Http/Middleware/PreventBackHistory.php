<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    $response = $next($request);

    if (method_exists($response, 'header')) {
        $response->headers->set('Cache-Control','no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','0');
    }

    return $response;
}

}
