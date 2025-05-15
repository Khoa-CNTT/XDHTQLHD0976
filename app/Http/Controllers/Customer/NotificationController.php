<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Hiển thị danh sách thông báo của người dùng hiện tại.
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.notifications.index', compact('notifications'));
    }

    /**
     * Hiển thị chi tiết một thông báo và đánh dấu là đã đọc.
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }

        return view('customer.notifications.show', compact('notification'));
    }

    /**
     * Đánh dấu tất cả thông báo là đã đọc.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tất cả thông báo đã được đánh dấu là đã đọc.'
            ]);
        }

        return redirect()->back()
            ->with('status', 'Tất cả thông báo đã được đánh dấu là đã đọc.');
    }

    /**
     * Tạo thông báo mới cho người dùng (dành cho admin).
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title'   => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title'   => $request->title,
            'message' => $request->message,
            'is_read' => false
        ]);

        return redirect()->back()
            ->with('status', 'Thông báo đã được gửi thành công.');
    }

    /**
     * API kiểm tra xem có thông báo mới không.
     */
    public function checkNewNotifications()
    {
        $lastChecked = session('last_notification_check', now()->subMinutes(30));
        session(['last_notification_check' => now()]);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $hasNewNotifications = Auth::user()->notifications()
            ->where('created_at', '>', $lastChecked)
            ->where('is_read', false)
            ->exists();

        return response()->json([
            'unreadCount'         => $unreadCount,
            'hasNewNotifications' => $hasNewNotifications,
            'lastChecked'         => $lastChecked->toDateTimeString()
        ]);
    }

    /**
     * API lấy 10 thông báo mới nhất.
     */
    public function getLatestNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id'         => $notification->id,
                    'title'      => $notification->title,
                    'message'    => $notification->message,
                    'is_read'    => $notification->is_read,
                    'created_at' => $notification->created_at->toDateTimeString(),
                    'time_ago'   => $notification->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    /**
     * Xóa một thông báo cụ thể.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->delete();

        return redirect()->back()
            ->with('status', 'Thông báo đã được xóa thành công.');
    }
}
