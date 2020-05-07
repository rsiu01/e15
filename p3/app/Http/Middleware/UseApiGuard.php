<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Auth;

use Closure;

class UseApiGuard
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
        Auth::shouldUse('api');

        // Or you can use auth()->setDefaultDriver('api')

        return $next($request);
    }
}
