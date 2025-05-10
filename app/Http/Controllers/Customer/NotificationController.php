<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Hiển thị thông báo cụ thể và đánh dấu là đã đọc
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Kiểm tra xem thông báo có thuộc về người dùng hiện tại không
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Đánh dấu thông báo là đã đọc
        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }
        
        // Tùy thuộc vào loại thông báo, có thể chuyển hướng đến trang khác nhau
        // Ví dụ: nếu thông báo liên quan đến hợp đồng, chuyển đến trang hợp đồng
        
        if (strpos($notification->message, 'hợp đồng') !== false) {
            return redirect()->route('customer.contracts.index')->with('notification', $notification->message);
        } elseif (strpos($notification->message, 'thanh toán') !== false) {
            return redirect()->route('customer.payments.index')->with('notification', $notification->message);
        }
        
        // Mặc định, quay lại trang cá nhân với thông báo
        return redirect()->route('customer.profile')->with('notification', $notification->message);
    }
    
    /**
     * Đánh dấu tất cả thông báo là đã đọc
     */
    public function markAllAsRead()
    {
        $user = auth()->user();
        
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return back()->with('success', 'Tất cả thông báo đã được đánh dấu là đã đọc.');
    }
} 