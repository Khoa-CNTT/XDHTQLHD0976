<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle($request, Closure $next)
    // {
    //     if (Auth::check() && Auth::user()->role === 'customer') {
    //         return $next($request);
    //     }

    //     return redirect('/login')->with('error', 'Bạn không có quyền truy cập.');
    // }


    public function handle($request, Closure $next)
{
    // Cho phép khách chưa đăng nhập truy cập vào trang customer/dashboard
    if ($request->is('customer/dashboard')) {
        return $next($request);
    }

    // Chỉ cho phép khách hàng đã đăng nhập truy cập các route khác
    if (Auth::check() && Auth::user()->role === 'customer') {
        return $next($request);
    }

    return redirect('/login')->with('error', 'Bạn không có quyền truy cập.');
}

}
