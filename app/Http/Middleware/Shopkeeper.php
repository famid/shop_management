<?php

namespace App\Http\Middleware;

use Closure;
use Closure as ClosureAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Shopkeeper
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param ClosureAlias $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role =='shopkeeper') {
            return $next($request);
        } else if(Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.home');

        } else {
            return redirect(route('login'));
        }
    }
}
