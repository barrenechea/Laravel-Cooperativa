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
        if(Auth::user()->is_admin && Auth::user()->roles->count() === 0)
        {
            Auth::logout();
            return redirect('/');
        }
        elseif(Auth::user()->locations->count() == 0)
        {
            return redirect('/');
        }

        if(!Auth::user()->initialized)
            return redirect('/init');

        dd($request);
        
        return $next($request);
    }
}