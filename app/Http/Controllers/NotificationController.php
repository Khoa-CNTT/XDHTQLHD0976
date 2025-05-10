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
        
        // Redirect to profile with a flash message
        return redirect()->route('customer.profile')
            ->with('status', 'Thông báo đã được đánh dấu là đã đọc.');
    }
    
    /**
     * Mark all notifications as read for the authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        // Update all unread notifications for the current user
        Auth::user()->notifications()
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
} 