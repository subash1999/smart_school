<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            $school_id = getCurrentSchoolId();
            if(isset($school_id)){
                try{
                    \App\School::findOrFail(getCurrentSchoolId());
                    return $next($request);
                }
                catch (ModelNotFoundException $e){

                }
            }
            abort(403,"Please Switch the Dashboard to Access \"School Admin Dashboard\"");
        }
        abort(403);
    }
}
