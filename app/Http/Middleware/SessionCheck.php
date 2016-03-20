<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class SessionCheck
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
        Log::info('sessionCheck');
        if(!Auth::check())
            return redirect('/');

        return $next($request);
    }
}
