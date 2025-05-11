<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\SupportTicket;
use App\Models\SupportResponse;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        
        // Cập nhật số điện thoại nếu có thay đổi
        if ($request->phone !== $user->phone) {
            // Kiểm tra xem số điện thoại này đã từng được sử dụng trước đó bởi người dùng này không
            $oldPhones = \App\Models\ActivityLog::where('user_id', $user->id)
                ->where('action', 'Cập nhật thông tin cá nhân')
                ->where('description', 'LIKE', '%đã thay đổi số điện thoại từ ' . $request->phone . ' thành%')
                ->count();
                
            if ($oldPhones > 0) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Số điện thoại này đã được bạn sử dụng trước đó. Vui lòng sử dụng số điện thoại khác.')
                    ->with('tab', 'info');
            }
            
            $user->phone = $request->phone;
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

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            
            // Lưu avatar mới
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

    /**
     * Hiển thị chi tiết yêu cầu hỗ trợ
     */
    public function viewSupportTicket($id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::with(['responses' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->where('user_id', $user->id)->findOrFail($id);
        
        return view('customer.support.show', compact('ticket'));
    }

    /**
     * Gửi phản hồi cho yêu cầu hỗ trợ
     */
    public function respondToSupportTicket(Request $request, $id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'response' => 'required|string',
        ], [
            'response.required' => 'Vui lòng nhập nội dung phản hồi',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Vui lòng nhập đầy đủ thông tin');
        }
        
        $response = new SupportResponse([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'content' => $request->response,
        ]);
        
        $response->save();
        
        // Tạo thông báo cho admin và nhân viên
        $admins = User::whereIn('role', ['admin', 'employee'])->get();
        foreach ($admins as $admin) {
            $notification = new Notification([
                'user_id' => $admin->id,
                'title' => 'Phản hồi mới từ khách hàng',
                'message' => 'Khách hàng "' . $user->name . '" đã phản hồi yêu cầu hỗ trợ #' . $ticket->id,
                'is_read' => false
            ]);
            
            $notification->save();
        }
        
        return redirect()->back()->with('success', 'Đã gửi phản hồi thành công');
    }

    /**
     * Hiển thị tất cả yêu cầu hỗ trợ của khách hàng
     */
    public function listSupportTickets()
    {
        $user = Auth::user();
        $tickets = SupportTicket::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('customer.support.index', compact('tickets'));
    }
}