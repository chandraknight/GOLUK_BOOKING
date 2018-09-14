<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission = null, ...$roles)
    {
//        if(Auth::guest()){
//            abort(404);
//        }

        foreach($roles as $role) {

            if (!$request->user()->hasRoles($role)) {

                return $next($request);
            }
        }


//        if ($permission !== null && !$request->user()->can($permission)) {
//            abort(404);
//        }



        abort(404);
    }
}
