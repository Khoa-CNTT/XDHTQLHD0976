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

//    dăng ký
    public function register(Request $request)
{
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^[\p{L}\s]+$/u' , // Chỉ cho phép tên có chữ cái và khoảng trắng
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users',
            'regex:/@gmail\.com$/', // Email phải có đuôi @gmail.com
        ],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/[A-Z]/', // Phải có ít nhất một ký tự in hoa
            'regex:/[0-9]/', // Phải có ít nhất một chữ số
            'regex:/[@$!%*?&]/', // Phải có ít nhất một ký tự đặc biệt
        ],
        'phone' => [
            'nullable',
            'string',
            'max:15',
            'regex:/^\d{10}$/', // Chỉ cho phép số và độ dài từ 10 
        ],
        'address' => 'nullable|string|max:255',
        'company_name' => 'required|string|max:255',
        'tax_code' => [
            'required',
            'string',
            'regex:/^\d{10}(\d{3})?$/',
            'unique:customers,tax_code', // Mã số thuế không được trùng
        ],
    ], [
        'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng, không chứa ký tự đặc biệt.',
        'email.regex' => 'Email phải có đuôi @gmail.com.',
        'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ in hoa, một số và một ký tự đặc biệt.',
        'password.confirmed' => 'Mật khẩu không khớp nhau.',
        'phone.regex' => 'Số điện thoại chỉ chứa các chữ số.',
        'phone.min' => 'Số điện thoại phải có 10 số.',
        'tax_code.regex' => 'Mã số thuế phải là số và có độ dài từ 10 đến 13 ký tự.',
        'tax_code.unique' => 'Mã số thuế này đã tồn tại.',
        'tax_code.min' => 'Mã số thuế phải có ít nhất 10 ký tự.',
    ]);

    
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'customer', 
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    
    Customer::create([
        'user_id' => $user->id,
        'company_name' => $request->company_name,
        'tax_code' => $request->tax_code,
    ]);

    
    Auth::login($user);

    return redirect()->route('customer.dashboard');
}
// public function register(Request $request)
// {
    
//     $request->validate([
//         'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
//         'email' => 'required|string|email|max:255|unique:users|regex:/^[a-z0-9._%+-]+@gmail\.com$/',
//         'phone' => 'required|string|regex:/^0[0-9]{9}$/', // Đảm bảo số điện thoại là số và có độ dài 10
//         'address' => 'required|string|max:255',
//         'password' => 'required|string|min:6|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
//         'company_name' => 'required|string|max:255',
//         'tax_code' => 'required|string|size:10|regex:/^[0-9]+$/|unique:customers,tax_code',
//     ]);

//     // Nếu dữ liệu hợp lệ, tạo tài khoản mới
//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'role' => 'customer', // Mặc định là khách hàng
//         'phone' => $request->phone,
//         'address' => $request->address,
//     ]);

//     // Tạo thông tin khách hàng
//     Customer::create([
//         'user_id' => $user->id,
//         'company_name' => $request->company_name,
//         'tax_code' => $request->tax_code,
//     ]);

//     // Đăng nhập sau khi đăng ký
//     Auth::login($user);

//     // Chuyển hướng tới trang dashboard
//     return redirect()->route('customer.dashboard');
// }


    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
