<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->paginate(15);
            
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'customer')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_read' => false
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('status', 'Thông báo đã được tạo thành công.');
    }

    /**
     * Show the form to send a notification to all users
     *
     * @return \Illuminate\Http\Response
     */
    public function createMassNotification()
    {
        return view('admin.notifications.mass-create');
    }

    /**
     * Send a notification to all active customers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMassNotification(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Get all active customer users
        $users = User::where('role', 'customer')
            ->where('status', 'active')
            ->get();

        // Create a notification for each user
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'is_read' => false
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('status', 'Thông báo đã được gửi đến tất cả người dùng thành công.');
    }

    /**
     * Remove the specified notification from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('status', 'Thông báo đã được xóa thành công.');
    }
} 