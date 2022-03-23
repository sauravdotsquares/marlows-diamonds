<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        echo Auth::user()->user_role; die;
        
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
        return redirect(route('admin.login'));

        $user = Auth::user();

        if(Auth::user()->user_role==1){
            return $next($request);
        }
        if(Auth::user()->user_role==2){
            return $next($request);
        }

        return redirect(route('admin.login'));
    }
}
