<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MrAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'mr')
    {
        echo "here";
        exit;
        if(!Auth::guard($guard)->check()){
            return redirect(Route('mr.login'));
        }
        return $next($request);
    }
}
