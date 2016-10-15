<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Hash;

use Closure;

class ApiKey
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
        if(!(Hash::check($request->header('authorization'), config('apiKey'))))
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        
        return $next($request);
    }
}