<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ManualAuth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user_id')) {
            return redirect('/login')->with('error', 'You must login first');
        }

        return $next($request);
    }
}