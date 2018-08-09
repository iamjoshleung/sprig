<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if( auth()->check() && auth()->user()->isAdmin() ) {
            return $next($request);
        }

        if( $request->expectsJson() ) {
            return response([], 401);
        }

        return redirect()->route('cm.login');
    }
}
