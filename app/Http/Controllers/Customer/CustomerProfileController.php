<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Storage;
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
            'phone' => ['required', 'string', 'regex:/^0[0-9]{9}$/', 'unique:users,phone,' . $user->id],
            'address' => 'required|string|min:5|max:255',
        ];

        $messages = [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Cập nhật thông tin thất bại. Vui lòng kiểm tra lại các trường thông tin.');
        }

        // Kiểm tra nếu không có thay đổi nào được thực hiện
        if ($request->phone === $user->phone && $request->address === $user->address) {
            return redirect()->back()
                ->with('info', 'Không có thông tin nào được thay đổi.')
                ->with('tab', 'info');
        }

        // Lưu số điện thoại cũ để ghi log
        $oldPhone = $user->phone;
        $oldAddress = $user->address;
        $hasChanges = false;
        $changeDescription = 'Bạn đã cập nhật thông tin cá nhân';
        $inputPhone = preg_replace('/\D/', '', trim($request->phone)); 
        $currentPhone = preg_replace('/\D/', '', trim($user->phone)); 
        // Cập nhật số điện thoại nếu có thay đổi
      if ($inputPhone !== $currentPhone) {
        // Kiểm tra số điện thoại đã có ai dùng chưa (bằng số thuần)
        $phoneExists = \App\Models\User::whereRaw("REPLACE(REPLACE(REPLACE(phone, '-', ''), ' ', ''), '.', '') = ?", [$inputPhone])
            ->where('id', '!=', $user->id) // Bỏ qua người dùng hiện tại
            ->exists();

        if ($phoneExists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Số điện thoại này đã được sử dụng bởi tài khoản khác.')
                ->with('tab', 'info');
        }

        // Nếu không trùng lặp, cập nhật số điện thoại mới vào DB
        $user->phone = $inputPhone;
        $hasChanges = true;
        $changeDescription .= ', đã thay đổi số điện thoại từ ' . $oldPhone . ' thành ' . $request->phone;
    }
        
        // Cập nhật địa chỉ nếu có thay đổi
        if ($request->address !== $user->address) {
            $user->address = $request->address;
            $hasChanges = true;
            $changeDescription .= ', đã thay đổi địa chỉ';
        }
        
        $user->save();
        
        // Ghi log hoạt động chi tiết hơn
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Cập nhật thông tin cá nhân',
            'description' => $changeDescription
        ]);
        
        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công.')->with('tab', 'info');
    }

    /**
     * Cập nhật avatar người dùng
     */
    public function updateAvatar(Request $request)
{
    $user = auth()->user();

    $rules = [
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];

    $messages = [
        'avatar.required' => 'Vui lòng chọn hình ảnh',
        'avatar.image' => 'File phải là hình ảnh',
        'avatar.mimes' => 'Định dạng hình ảnh phải là: jpeg, png, jpg, gif',
        'avatar.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Cập nhật ảnh đại diện thất bại. Vui lòng kiểm tra lại file ảnh.');
    }

    if ($request->hasFile('avatar')) {
        // Xoá ảnh cũ nếu không phải ảnh mặc định
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Lưu ảnh mới vào thư mục avatars/
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $avatarPath;
        $user->save();

        // Ghi log hoạt động
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Cập nhật ảnh đại diện',
            'description' => 'Bạn đã cập nhật ảnh đại diện'
        ]);

        return redirect()->back()->with('success', 'Ảnh đại diện đã được cập nhật thành công.')->with('tab', 'info');
    }

    return redirect()->back()->with('error', 'Không tìm thấy file ảnh để cập nhật.');
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

}