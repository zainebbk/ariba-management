<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActiveUser
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
        if (Auth::guard("vendor")->check() && auth()->user()->blocked) {
            $user = Auth::guard("vendor")->user();
            auth()->logout();

            return redirect()->route('vendor.login')
            ->withErrors(['status' => __('Your account has been banned. Please contact our support for more details !')]);     
        }
        return $next($request);
    }
}
