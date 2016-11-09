<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Storage
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
        if ( Auth::check() && Auth::user()->isStorage() )
        {
            return $next($request);
        }

        return redirect('/');
    }
}
