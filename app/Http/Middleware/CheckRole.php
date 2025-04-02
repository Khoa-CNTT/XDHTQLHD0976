<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Xử lý yêu cầu.
     * $roles có thể là 1 chuỗi hoặc danh sách các vai trò được phép.
     */
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userRole = Auth::user()->role;
    $userRole = $user->role; // Lấy trực tiếp từ cột role
    if (!in_array($userRole, $roles)) {
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }

    return $next($request);
}

}
//Middleware này dùng để kiểm tra xem user có quyền truy cập vào trang đó không
//nếu không thì sẽ trả về lỗi 403
//ví dụ: Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin,staff')->name('dashboard');    
