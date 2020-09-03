<?php

namespace App\Http\Middleware;

use Closure;

class Teacher
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
        $auth = auth()->user() ? auth()->user()->isTeacher() : false;
        if ($auth){
            if(strcasecmp(session("current_role"),"Teacher")==0
                && ($request->school_id == session("current_school_id"))){
                return $next($request);
            }
            abort(403,"Please Switch the Dashboard to Access \"Teacher Dashboard\" ");
        }
        abort(403);
    }
}
