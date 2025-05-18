<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    protected $redirectTo = '/customer/dashboard';

    public function reset(Request $request)
{
    // Validate password fields với điều kiện mới
    $request->validate([
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[A-Z]/', // ít nhất một chữ cái viết hoa
            'regex:/[a-z]/', // ít nhất một chữ cái viết thường
            'regex:/[0-9]/', // ít nhất một chữ số
            'regex:/[\W_]/', // ít nhất một ký tự đặc biệt
        ],
        'password_confirmation' => 'required|min:8',
    ], [
        'password.required' => 'Mật khẩu là bắt buộc.',
        'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.',
        'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa, một chữ cái viết thường, một chữ số và một ký tự đặc biệt.',
        'password_confirmation.required' => 'Xác nhận mật khẩu là bắt buộc.',
        'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
    ]);

    // Email từ link reset mật khẩu
    $email = $request->email;
    // Token từ link reset mật khẩu
    $token = $request->token;
    
    // Kiểm tra xem token có hợp lệ không
    $resetRecord = DB::table('password_resets')
        ->where('email', $email)
        ->first();

    if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
        return back()->withErrors(['email' => 'Token không hợp lệ.']);
    }

    // Kiểm tra xem email có tồn tại trong hệ thống không
    $user = \App\Models\User::where('email', $email)->first();

    // Nếu không tìm thấy người dùng với email này, trả về lỗi
    if (!$user) {
        return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
    }   

    // Reset mật khẩu
    $response = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            // Cập nhật mật khẩu
            $user->password = bcrypt($password);
            $user->save();
        }
    );

    // Xóa bản ghi token sau khi reset mật khẩu thành công
    DB::table('password_resets')->where('email', $email)->delete();

    // Kiểm tra kết quả trả về từ reset
    return $response == Password::PASSWORD_RESET
        ? redirect($this->redirectPath())->with('status', 'Mật khẩu đã được đặt lại!')
        : back()->withErrors(['email' => [trans($response)]]);
}




}
