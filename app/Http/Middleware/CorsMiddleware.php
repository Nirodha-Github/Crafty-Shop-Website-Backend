<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
        ->header('Access-Control-Allow-Origin', config('cors.allowed_origin')) 
        ->header('Access-Control-Allow-Methods', config('cors.allowed_methods'))
        ->header('Access-Control-Allow-Headers', config('cors.allowed_headers'))
        ->header('Access-Control-Expose-Headers', config('cors.exposed_headers'))
        ->header('Access-Control-Allow-Credentials',"true");
    }
}
