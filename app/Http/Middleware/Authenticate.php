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
    // Nếu người dùng đã đăng nhập
    if (Auth::check()) {
        // Kiểm tra trạng thái tài khoản
        if (Auth::user()->status === 'banned') {
            Auth::logout(); // Đăng xuất người dùng
            return redirect()->route('login')->withErrors(['error' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với nhân vien.']);
        }

        return $next($request);
    }

   
}
}
