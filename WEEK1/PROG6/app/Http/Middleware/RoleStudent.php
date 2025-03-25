<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'student') {
            return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập.');
        }
        return $next($request);
    }
}
