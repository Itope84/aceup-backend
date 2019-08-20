<?php

namespace App\Http\Middleware;

use Closure;

class IsPrivileged
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
        if(!$request->user()->is_privileged()) {
            return redirect(route('home'));
        }
        return $next($request);
    }
}
