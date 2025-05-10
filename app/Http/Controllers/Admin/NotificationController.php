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
    public function index(Request $request)
    {
        $query = Notification::with('user');
        
        // Filter by user if provided
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by read status if provided
        if ($request->has('is_read') && $request->is_read != '') {
            $query->where('is_read', $request->is_read);
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Filter by title or message content
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('message', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $notifications = $query->latest()->paginate(15);
        
        // Get all customers for filter dropdown
        $users = User::where('role', 'customer')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
            
        return view('admin.notifications.index', compact('notifications', 'users'));
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

        // Kiểm tra thông báo trùng lặp trong vòng 5 phút qua
        $exists = Notification::where('user_id', $validated['user_id'])
            ->where('title', $validated['title'])
            ->where('message', $validated['message'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();
            
        if (!$exists) {
            $notification = Notification::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'message' => $validated['message'],
                'is_read' => false
            ]);
            
            return redirect()->route('admin.notifications.index')
                ->with('status', 'Thông báo đã được tạo thành công.');
        } else {
            return redirect()->route('admin.notifications.index')
                ->with('warning', 'Thông báo tương tự đã được gửi trong 5 phút qua. Hệ thống đã chặn thông báo trùng lặp.');
        }
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

        $notificationCount = 0;
        $skippedCount = 0;

        // Create a notification for each user
        foreach ($users as $user) {
            // Kiểm tra thông báo trùng lặp trong vòng 5 phút qua
            $exists = Notification::where('user_id', $user->id)
                ->where('title', $validated['title'])
                ->where('message', $validated['message'])
                ->where('created_at', '>', now()->subMinutes(5))
                ->exists();
                
            if (!$exists) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'is_read' => false
                ]);
                $notificationCount++;
            } else {
                $skippedCount++;
            }
        }

        if ($skippedCount > 0) {
            return redirect()->route('admin.notifications.index')
                ->with('status', "Đã gửi thông báo đến {$notificationCount} người dùng. Bỏ qua {$skippedCount} người dùng do thông báo trùng lặp.");
        } else {
            return redirect()->route('admin.notifications.index')
                ->with('status', "Thông báo đã được gửi đến tất cả {$notificationCount} người dùng thành công.");
        }
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
    
    /**
     * Remove all notifications based on filter criteria
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        // Bắt đầu với query cơ bản
        $query = Notification::query();
        $hasFilters = false;
        
        // Apply filters if they exist in the request
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
            $hasFilters = true;
        }
        
        if ($request->has('is_read') && $request->is_read != '') {
            $query->where('is_read', $request->is_read);
            $hasFilters = true;
        }
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
            $hasFilters = true;
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
            $hasFilters = true;
        }
        
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('message', 'LIKE', "%{$searchTerm}%");
            });
            $hasFilters = true;
        }
        
        // Get count before deletion for status message
        $count = $query->count();
        
        // Delete the notifications
        $query->delete();
        
        // Thông báo thành công
        if ($hasFilters) {
            $message = $count > 0 
                ? "Đã xóa thành công {$count} thông báo đã lọc." 
                : "Không có thông báo nào phù hợp với bộ lọc để xóa.";
        } else {
            $message = $count > 0 
                ? "Đã xóa thành công tất cả {$count} thông báo." 
                : "Không có thông báo nào để xóa.";
        }
            
        return redirect()->route('admin.notifications.index')
            ->with('status', $message);
    }
} 