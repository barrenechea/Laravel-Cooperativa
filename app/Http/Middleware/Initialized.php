<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Validation;

class Initialized
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
        // Account is enabled validation
        if((Auth::user()->is_admin && Auth::user()->roles->count() === 0) || (isset(Auth::user()->partner) && Auth::user()->partner->locations->count() === 0))
        {
            Auth::logout();
            return redirect()->back()->withErrors(['Su cuenta se encuentra deshabilitada']);
        }

        if(!Auth::user()->initialized)
            return redirect('/init');
        
        return $next($request);
    }
}