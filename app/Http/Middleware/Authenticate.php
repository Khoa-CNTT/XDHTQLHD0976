<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
{
    // Nếu người dùng đã đăng nhập, cho phép tiếp tục xử lý yêu cầu
    if (Auth::check()) {
        return $next($request);
    }

    // Nếu người dùng chưa đăng nhập và đang cố gắng truy cập vào trang của khách hàng
    if ($request->is('customer/dashboard')) {
        // Cho phép khách chưa đăng nhập truy cập vào trang customer/dashboard
        return $next($request);
    }

    // Nếu không, chuyển hướng về trang login
    return redirect()->route('login');
}
}
