<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    |quên mật khẩu
    | Đây là nơi bạn có thể định nghĩa các phương thức để xử lý việc gửi email đặt lại mật khẩu.
    */

    use SendsPasswordResetEmails;
      /**
     * 
     *
     * @return \Illuminate\View\View
     */
    
    public function showLinkRequestForm()
{
    return view('auth.passwords.email');
}   
      /**
     * Gửi email yêu cầu đặt lại mật khẩu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function sendResetLinkEmail(Request $request)
    {
        // Kiểm tra xem email có tồn tại trong hệ thống không
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);

        // Gửi email reset mật khẩu
        try {
            $response = Password::sendResetLink(
                $request->only('email')
            );

            // Xử lý kết quả sau khi gửi email
            return $response == Password::RESET_LINK_SENT
                ? back()->with('status', 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.')
                : back()->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
        } catch (\Exception $e) {
            // Nếu có lỗi trong quá trình gửi email, bạn có thể ghi log hoặc trả về thông báo lỗi chi tiết hơn
            return back()->withErrors(['email' => 'Có lỗi khi gửi email. Vui lòng thử lại sau.']);
        }
    }
 
}
