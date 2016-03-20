<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Session;

class PermissionMiddleware
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
        // Log::info('ROLE ' . Session::get('role'));
        // Log::info('route - - - -');
        // Log::info(json_encode($request->route()->getPath()));
        // Log::info(json_encode($request->route()->getName()));
        // Log::info(json_encode($request->route()->getOptions()));
        // if($request->route()->getName() != Session::get('role'))
        //     return ;

        return $next($request);
    }
}
