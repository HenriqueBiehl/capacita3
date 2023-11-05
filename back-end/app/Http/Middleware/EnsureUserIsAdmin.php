<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsAdmin
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
        if(!$request->user()->isAdmin){
            return response()->json([
                'message' => 'Admin privileges required'
            ], 401);
        }
        
        return $next($request);
    }
}
