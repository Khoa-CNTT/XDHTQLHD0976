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
      $currentYear = now()->year;
     
    // Xử lý ngày sinh
    $dob = null;
    try {
        // Kiểm tra định dạng ngày và chuyển đổi
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $request->dob)) {
            // Định dạng d/m/Y (VD: 23/01/2003)
            $dob = \Carbon\Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');
        } else if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->dob)) {
            // Định dạng Y-m-d (VD: 2003-01-23)
            $dob = $request->dob;
        } else {
            return back()->withInput()->withErrors(['dob' => 'Ngày sinh không đúng định dạng. Vui lòng nhập theo định dạng ngày/tháng/năm (VD: 23/01/2003).']);
        }
    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['dob' => 'Ngày sinh không hợp lệ. Vui lòng kiểm tra lại (định dạng: ngày/tháng/năm).']);
    }

    // Thay thế giá trị ngày sinh trong request để validation có thể xử lý đúng
    $request->merge(['dob' => $dob]);

    if ($dob == '0000-00-00') {
        return back()->withErrors(['dob' => 'Ngày sinh không thể là ngày mặc định 0000-00-00.']);
    }
    $request->validate([
         'name' => [
        'required',
        'string',
        'max:255',
        'regex:/^([A-ZÀ-Ỹ][a-zà-ỹ]+)(\s[A-ZÀ-Ỹ][a-zà-ỹ]+)+$/u',
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users',
            'regex:/@gmail\.com$/', // Email phải có đuôi @gmail.com
        ],
         'identity_card' => [
        'required',
        'string',
        'regex:/^\d{12}$/', // Căn cước công dân bắt buộc 12 chữ số
        'unique:users,identity_card', // Không được trùng
        ],
           'dob' => [
            'required',
            'date',
            'before:today',
            'after:1900-01-01',
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
        'required',
        'regex:/^0\d{9}$/',  
        'max:10',
        'min:10' 
        ],
        'address' => [
        'required',
        'string',
        'max:255',
    ],
        'company_name' => [
        'required',
        'string',
        'regex:/^[\p{L}0-9\s\.\,\-\(\)]+$/u', // Tên công ty có thể gồm chữ, số, dấu cách và các dấu cơ bản
        'max:255',
    ],
        'tax_code' => [
        'required',
        'string',
        'regex:/^\d{10}$/',  // Mã số thuế bắt buộc 10 số
        'unique:customers,tax_code',
    ],
    ], [
    'name.regex' => 'Họ tên phải đầy đủ (ít nhất 2 từ), viết hoa chữ cái đầu, không chứa ký tự đặc biệt.',
    'email.regex' => 'Email phải có đuôi @gmail.com.',
    'identity_card.regex' => 'Căn cước công dân phải đúng 12 chữ số.',
    'dob.date' => 'Ngày sinh phải là một ngày hợp lệ.',
          'dob.before' => 'Ngày sinh phải là ngày trong quá khứ và không thể trùng với ngày hôm nay.',
        'dob.after' => 'Ngày sinh không được quá xa trong quá khứ.',
        'dob.date_format' => 'Ngày sinh phải theo định dạng (ví dụ: 23-01-2003).',
        'dob.before:' . $currentYear . '-12-31' => 'Ngày sinh không thể sau năm hiện tại ('.$currentYear.').',
    'phone.required' => 'Số điện thoại bắt buộc nhập.',
    'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và gồm đúng 10 chữ số.',
    'company_name.regex' => 'Tên công ty chỉ bao gồm chữ, số, và một số ký tự cơ bản.',
    'tax_code.regex' => 'Mã số thuế phải là số và gồm đúng 10 chữ số.',

    'password.regex' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ số và ký tự đặc biệt.',
    'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    'identity_card.unique' => 'Căn cước công dân đã tồn tại.',
    'email.unique' => 'Email đã tồn tại.',
    'tax_code.unique' => 'Mã số thuế đã tồn tại.',
    'phone.unique' => 'Số điện thoại đã tồn tại.',
    'address.required' => 'Địa chỉ không được để trống.',
    'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
    'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
    'company_name.required' => 'Tên công ty không được để trống.',
    'company_name.string' => 'Tên công ty phải là một chuỗi ký tự.',
    'company_name.max' => 'Tên công ty không được vượt quá 255 ký tự.',
    'tax_code.required' => 'Mã số thuế không được để trống.',
    'tax_code.string' => 'Mã số thuế phải là một chuỗi ký tự.',
    'tax_code.max' => 'Mã số thuế không được vượt quá 10 ký tự.',
    'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
    'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
    'phone.min' => 'Số điện thoại không được ít hơn 10 ký tự.',
   
    'identity_card.required' => 'Căn cước công dân không được để trống.',
    'identity_card.string' => 'Căn cước công dân phải là một chuỗi ký tự.',
    'identity_card.max' => 'Căn cước công dân không được vượt quá 12 ký tự.',
    'identity_card.min' => 'Căn cước công dân không được ít hơn 12 ký tự.',
    'email.required' => 'Email không được để trống.',
    'email.string' => 'Email phải là một chuỗi ký tự.',
    'email.max' => 'Email không được vượt quá 255 ký tự.',
    'email.email' => 'Email không đúng định dạng.',
    'password.required' => 'Mật khẩu không được để trống.',     
]);



    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'identity_card' => $request->identity_card, 
    'dob' => $dob,
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



    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
