<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAccountant
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'accountant') {
            return $next($request);
        }
        return redirect('home')->with('error', 'You do not have Accountant access');
    }
}
