<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'host') {
            return redirect('/login')->with('error', 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
}
