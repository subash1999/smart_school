<?php

namespace App\Http\Middleware;

use Closure;

class SchoolAdmin
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
        $auth = auth()->user() ? auth()->user()->isSchoolAdmin() : false;
        if ($auth){
            if(strcasecmp(session("current_role"),"School Admin")==0
            && ($request->school_id == session("current_school_id"))){
                return $next($request);
            }
            abort(403,"Please Switch the Dashboard to Access \"School Admin Dashboard\"");
        }
        abort(403);
    }
}
