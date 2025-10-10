<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'teacher') {
            return $next($request);
        }
        return redirect('home')->with('error', 'You do not have Teacher access');
    }
}
