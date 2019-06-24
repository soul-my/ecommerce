<?php

namespace App\Http\Middleware\User;

use Closure;

class RedirectIfNotAuthenticated
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
        dd($request);
        if(Auth::guard('web')->check() == false)
        {
            return redirect()->route('store.user.login');
        }

        return $next($request);
    }
}
