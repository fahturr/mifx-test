<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check() && !Auth::user()->is_admin) {
            return abort(403, 'Forbidden');
        } 
        
        if (!Auth::check()) {
            return abort(401, 'Unauthorized');
        }
        
        return $next($request);
    }
}
