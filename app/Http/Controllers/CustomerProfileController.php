<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\SupportTicket;

class CustomerProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $customer = $user->customer;
        $avatar = $user->avatar;
        $notifications = $user->notifications()->latest()->take(5)->get();
        $activities = $user->activityLogs()->latest()->take(10)->get();
        $supportTickets = $user->supportTickets()->latest()->take(5)->get();
        $contracts = $user->customer->contracts()->with('service')->latest()->take(5)->get();
        $payments = $user->customer->payments()->latest()->take(5)->get();
        
        return view('customer.profile', compact('user', 'customer', 'avatar', 'notifications', 'activities', 'supportTickets', 'contracts', 'payments'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,phone,' . $user->id],
            'address' => 'required|string|min:5|max:255',
        ];

        $messages = [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại phải có đúng 10 chữ số',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        ];

        // Kiểm tra xem có file avatar được gửi lên không
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
            $messages['avatar.image'] = 'File phải là hình ảnh';
            $messages['avatar.mimes'] = 'Định dạng hình ảnh phải là: jpeg, png, jpg, gif';
            $messages['avatar.max'] = 'Kích thước hình ảnh không được vượt quá 2MB';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Cập nhật thông tin thất bại. Vui lòng kiểm tra lại các trường thông tin.');
        }

        // Cập nhật thông tin cơ bản
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Xử lý upload avatar nếu có
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            
            // Lưu avatar mới
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();
        
        // Ghi log hoạt động - chỉ sử dụng các trường có trong bảng
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Cập nhật thông tin cá nhân',
            'description' => 'Bạn đã cập nhật thông tin cá nhân'
            // Không cần trường updated_at, nó không tồn tại trong bảng
        ]);

        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công.')->with('tab', 'info');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // ít nhất 1 chữ cái thường
                'regex:/[A-Z]/',      // ít nhất 1 chữ cái hoa
                'regex:/[0-9]/',      // ít nhất 1 số
                'regex:/[@$!%*#?&]/'  // ít nhất 1 ký tự đặc biệt
            ],
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'new_password.regex' => 'Mật khẩu phải có ít nhất một chữ cái thường, một chữ cái hoa, một số và một ký tự đặc biệt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Đổi mật khẩu thất bại. Vui lòng kiểm tra lại thông tin.')
                ->with('tab', 'password');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Mật khẩu hiện tại không chính xác.')
                ->with('tab', 'password');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        
        // Ghi log hoạt động
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Đổi mật khẩu',
            'description' => 'Bạn đã thay đổi mật khẩu thành công'
        ]);

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công.')->with('tab', 'password');
    }

    public function createSupportTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề yêu cầu hỗ trợ',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'content.required' => 'Vui lòng nhập nội dung yêu cầu hỗ trợ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gửi yêu cầu hỗ trợ thất bại. Vui lòng kiểm tra lại thông tin.');
        }

        $user = auth()->user();
        
        $ticket = new SupportTicket([
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'Chờ xử lý',
        ]);

        $user->supportTickets()->save($ticket);
        
        // Ghi log hoạt động
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Gửi yêu cầu hỗ trợ',
            'description' => 'Bạn đã gửi một yêu cầu hỗ trợ mới: ' . $request->title
        ]);

        return redirect()->back()->with('success', 'Yêu cầu hỗ trợ đã được gửi thành công.');
    }
}