<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Auth;

class RedirectIfNotAdmin
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
        if(Auth::guard('admin')->check() == false)
        {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
