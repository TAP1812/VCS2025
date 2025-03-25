<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'teacher') {
            return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập.');
        }
        return $next($request);
    }
}
