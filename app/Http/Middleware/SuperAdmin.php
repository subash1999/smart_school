<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
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
        $auth = auth()->user() ? auth()->user()->isSuperAdmin() : false;
        if ($auth){
            if(strcasecmp(session("current_role"),"Super Admin")==0){
                return $next($request);
            }
            abort(403,"Please Change the Dashboard to Access \"Super Admin Dashboard\" ");
        }
        abort(403);
    }
}
