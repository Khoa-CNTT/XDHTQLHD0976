<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Customer; 
use Illuminate\Support\Facades\Password;
class AuthController extends Controller
{
    public function showLinkRequestForm()
{
    return view('auth.passwords.email');
}
    //quenmk
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Gửi email reset mật khẩu
    $response = Password::sendResetLink($request->only('email'));

    if ($response == Password::RESET_LINK_SENT) {
        return back()->with('status', 'Đã gửi liên kết reset mật khẩu vào email của bạn!');
    }

    return back()->withErrors(['email' => 'Không thể tìm thấy email này trong hệ thống.']);
}
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            // Nếu người dùng tích "ghi nhớ đăng nhập"
            if ($request->has('remember_credentials')) {
                Cookie::queue('remember_email', $request->email, 60 * 24 * 7);     // 7 ngày
                Cookie::queue('remember_password', $request->password, 60 * 24 * 7);
            } else {
                Cookie::queue(Cookie::forget('remember_email'));
                Cookie::queue(Cookie::forget('remember_password'));
            }
        
            // Điều hướng theo role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'customer') {
                return redirect()->route('customer.dashboard');
            }
        }
    
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác']);
    }

    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

 
    // Xử lý đăng ký tài khoản
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'tax_code' => 'required|string|max:50|unique:customers,tax_code',
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Mặc định là khách hàng
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Tạo thông tin khách hàng
        Customer::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'tax_code' => $request->tax_code,
        ]);

        // Đăng nhập sau khi đăng ký
        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
