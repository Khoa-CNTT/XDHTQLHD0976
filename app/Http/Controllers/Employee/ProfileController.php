<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Hiển thị thông tin cá nhân của nhân viên
     */
    public function show()
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $user = Auth::user();
        $employee = $user->employee;
        
        return view('admin.employees.profile', compact('user', 'employee'));
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function update(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $user = Auth::user();
        
        // Xác định trường nào đang được cập nhật
        $isUpdatingPhone = $request->has('phone') && $request->phone != $user->phone;
        $isUpdatingAddress = $request->has('address') && $request->address != $user->address;
        
        // Tạo validation rules chỉ cho các trường đang cập nhật
        $rules = [];
        $messages = [];
        
        if ($isUpdatingPhone) {
            $rules['phone'] = ['required', 'string', 'regex:/^0[0-9]{9}$/'];
            $messages['phone.required'] = 'Vui lòng nhập số điện thoại';
            $messages['phone.regex'] = 'Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số';
        }
        
        if ($isUpdatingAddress) {
            $rules['address'] = 'required|string|min:5|max:255';
            $messages['address.required'] = 'Vui lòng nhập địa chỉ';
            $messages['address.min'] = 'Địa chỉ phải có ít nhất 5 ký tự';
            $messages['address.max'] = 'Địa chỉ không được vượt quá 255 ký tự';
        }
        
        // Nếu có trường cần validation thì mới validate
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }

        // Kiểm tra nếu không có thay đổi nào
        $hasChanges = false;
        $updatedFields = [];
        
        // Cập nhật số điện thoại nếu có thay đổi
        if ($isUpdatingPhone) {
            $user->phone = $request->phone;
            $hasChanges = true;
            $updatedFields[] = 'số điện thoại';
        }
        
        // Cập nhật địa chỉ nếu có thay đổi
        if ($isUpdatingAddress) {
            $user->address = $request->address;
            $hasChanges = true;
            $updatedFields[] = 'địa chỉ';
        }
        
        if ($hasChanges) {
            $user->save();
            
            // Ghi log hoạt động nếu có
            if (class_exists('\\App\\Models\\ActivityLog')) {
                \App\Models\ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'Cập nhật thông tin cá nhân',
                    'description' => 'Đã cập nhật: ' . implode(', ', $updatedFields)
                ]);
            }
            
            return redirect()->back()->with('success', 'Đã cập nhật ' . implode(' và ', $updatedFields) . ' thành công.');
        }
        
        return redirect()->back()->with('info', 'Không có thông tin nào được thay đổi.');
    }

    /**
     * Cập nhật avatar riêng biệt
     */
    public function updateAvatar(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }
        
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.required' => 'Vui lòng chọn hình ảnh',
            'avatar.image' => 'File phải là hình ảnh',
            'avatar.mimes' => 'Định dạng hình ảnh phải là: jpeg, png, jpg, gif',
            'avatar.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Cập nhật ảnh đại diện thất bại. Vui lòng kiểm tra lại file ảnh.');
        }
        
        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Lưu avatar mới
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
            
            // Có thể thêm ghi log hoạt động ở đây nếu cần
            
            return redirect()->back()->with('success', 'Ảnh đại diện đã được cập nhật thành công.');
        }
        
        return redirect()->back()->with('error', 'Không tìm thấy file ảnh để cập nhật.');
    }

    /**
     * Đổi mật khẩu
     */
    public function changePassword(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => [
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
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.regex' => 'Mật khẩu phải có ít nhất một chữ cái thường, một chữ cái hoa, một số và một ký tự đặc biệt',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        $user = Auth::user();
        
        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                    ->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.'])
                    ->withInput();
        }
        
        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Ghi log hoạt động nếu có
        if (class_exists('\\App\\Models\\ActivityLog')) {
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Đổi mật khẩu',
                'description' => 'Bạn đã thay đổi mật khẩu thành công'
            ]);
        }
        
        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
} 