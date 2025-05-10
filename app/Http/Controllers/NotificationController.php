<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Show a specific notification and mark it as read
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Verify that the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Mark notification as read if it's not already
        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }
        
        // Hiển thị trang chi tiết thông báo
        return view('customer.notifications.show', compact('notification'));
    }
    
    /**
     * Mark all notifications as read for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
       
        $notificationIds = Auth::user()->notifications()
            ->where('is_read', false)
            ->pluck('id')
            ->toArray();
            

        Notification::whereIn('id', $notificationIds)
            ->update(['is_read' => true]);
        
        return redirect()->back()
            ->with('status', 'Tất cả thông báo đã được đánh dấu là đã đọc.');
    }
    
    /**
     * List all notifications for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);
        
        return view('customer.notifications.index', compact('notifications'));
    }
    
    /**
     * Admin method to create a new notification for a specific user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        // Lưu thời điểm kiểm tra cuối cùng trong session
        $lastChecked = session('last_notification_check', now()->subMinutes(30));
        session(['last_notification_check' => now()]);
        
        // Đếm số lượng thông báo chưa đọc (loại bỏ trùng lặp)
        $unreadCount = Auth::user()->notifications()
            ->where('is_read', false)
            ->get()
            ->unique('id')
            ->count();
        
        // Kiểm tra xem có thông báo mới kể từ lần kiểm tra trước không
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
        $notifications = Auth::user()->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->unique('id')
            ->take(5)
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
} 