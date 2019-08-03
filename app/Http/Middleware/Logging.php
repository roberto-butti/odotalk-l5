<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug("MDW DEBUG: " . $request->getRequestUri());
        return $next($request);
    }

    /**
     * Handle an outcoming response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return mixed
     */
    public function terminate($request, $response)
    {
        Log::debug("MDW DEBUG: " . $response->getStatusCode());
    }
}
