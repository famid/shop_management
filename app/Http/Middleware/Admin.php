<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
        return $next($request);
        } else if(Auth::check() && Auth::user()->role == 'shopkeeper') {
          return redirect()->route('shopkeeper.home');

        } else {
            return redirect(route('login'));
        }
    }
}
