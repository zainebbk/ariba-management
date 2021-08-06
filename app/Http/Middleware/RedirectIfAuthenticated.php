<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        if ($guard == "web" && Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::Dashboard);
        }

        if ($guard == "vendor" && Auth::guard($guard)->check()) {
            return redirect('/vendor/dashboard');
        }

        if ($guard == "employee" && Auth::guard($guard)->check()) {
            return redirect('/employee/dashboard');
        }

        return $next($request);
    }
}
