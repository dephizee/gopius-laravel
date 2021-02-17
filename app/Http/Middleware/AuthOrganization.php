<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::guard('organization')->user()->approved);
        if (!Auth::guard('organization')->check()) {
            
            return redirect('/');
        }
        if ( !Auth::guard('organization')->user()->approved) {
            return redirect('/')->withErrors([
                    'Account yet to be approved',
                ]);
        }
        return $next($request);
    }
}
