<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;        
use App\Http\Requests\NotificationRequest;
use App\Http\Controllers\Controller; 
use App\Models\SupportTicket;

class NotificationController extends Controller
{
    /**
     * Show a specific notification and mark it as read
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
   public function index()
{
    $notifications = Notification::where('user_id', Auth::id()) // Chỉ lấy thông báo của người dùng hiện tại
        ->latest()
        ->paginate(10);

    return view('customer.notifications.index', compact('notifications'));
}

    /**
     * Show a specific notification and mark it as read
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
   public function show($id)
{
    $notification = Notification::findOrFail($id);
    
    // Xác minh thông báo thuộc về người dùng hiện tại
    if ($notification->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    // Đánh dấu thông báo là đã đọc nếu chưa đọc
    if (!$notification->is_read) {
        $notification->is_read = true;
        $notification->save();
    }
    
    return view('customer.notifications.show', compact('notification'));
}
    
    /**
     * Mark all notifications as read for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
   public function markAllAsRead()
{
    Notification::where('user_id', Auth::id())
        ->where('created_by', 'employee') // Chỉ đánh dấu thông báo từ nhân viên
        ->where('is_read', false)
        ->update(['is_read' => true]);
    
    return redirect()->back()
        ->with('status', 'Tất cả thông báo đã được đánh dấu là đã đọc.');
}
    /**
     * List all notifications for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
   
     
    
    /**
     * Admin method to create a new notification for a specific user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);
        
        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'is_read' => false
        ]);
        
        return redirect()->back()
            ->with('status', 'Thông báo đã được gửi thành công.');
    }
    
    /**
     * API endpoint để kiểm tra thông báo mới
     *
     * @return \Illuminate\Http\JsonResponse
     */
   public function checkNewNotifications()
{
    $lastChecked = session('last_notification_check', now()->subMinutes(30));
    session(['last_notification_check' => now()]);
    
  $unreadCount = Notification::where('user_id', Auth::id()) // Chỉ lấy thông báo của người dùng hiện tại
    ->where('is_read', false)
    ->count();
    
    $hasNewNotifications = Auth::user()->notifications()
        ->where('created_at', '>', $lastChecked)
        ->where('is_read', false)
        ->exists();
    
    return response()->json([
        'unreadCount' => $unreadCount,
        'hasNewNotifications' => $hasNewNotifications,
        'lastChecked' => $lastChecked->toDateTimeString()
    ]);
}
    /**
     * API endpoint để lấy danh sách thông báo mới nhất
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestNotifications()
{
    $notifications = Notification::where('user_id', Auth::id()) // Chỉ lấy thông báo của người dùng hiện tại
        ->latest()
        ->take(10)
        ->get()
        ->map(function($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'is_read' => $notification->is_read,
                'created_at' => $notification->created_at->toDateTimeString(),
                'time_ago' => $notification->created_at->diffForHumans()
            ];
        });
    
    return response()->json([
        'notifications' => $notifications
    ]);
}

    /**
     * Xóa thông báo
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Xác minh thông báo thuộc về người dùng hiện tại
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->delete();
        
        return redirect()->back()
            ->with('status', 'Thông báo đã được xóa thành công.');
    }
} 