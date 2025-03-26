<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isTeacher()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
