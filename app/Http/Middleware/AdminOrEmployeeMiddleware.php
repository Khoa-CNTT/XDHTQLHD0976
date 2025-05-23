<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class AdminOrEmployeeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'employee'])) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Bạn không có quyền truy cập.');
    }
}
