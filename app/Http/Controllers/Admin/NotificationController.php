<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\SupportTicket;
use App\Models\SupportTicketResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Gửi phản hồi cho yêu cầu hỗ trợ.
     */
    public function respond(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        // Lưu phản hồi
        $ticket->responses()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        // Không tạo thông báo cho phản hồi từ nhân viên
        return response()->json([
            'success' => true,
            'message' => 'Phản hồi đã được gửi.',
        ]);
    }

    /**
     * Hiển thị danh sách thông báo.
     */
    public function index(Request $request)
    {
        $query = Notification::with('user')
            ->whereIn('created_by', ['admin', 'employee']); // Chỉ lấy thông báo do admin/employee tạo

        // Lọc theo người dùng
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Lọc theo trạng thái đã đọc
        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        // Lọc theo ngày bắt đầu
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Lọc theo ngày kết thúc
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Tìm kiếm theo tiêu đề hoặc nội dung
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('message', 'LIKE', "%{$searchTerm}%");
            });
        }

        $notifications = $query->latest()->paginate(10);

        $users = User::where('role', 'customer')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    /**
     * Hiển thị form tạo thông báo mới.
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
     * Lưu thông báo mới vào hệ thống.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = User::find($validated['user_id']);

        if ($user->role !== 'customer') {
            return redirect()->route('admin.notifications.index')
                ->with('warning', 'Chỉ được gửi thông báo cho khách hàng.');
        }

        // Kiểm tra thông báo trùng lặp trong 5 phút
        $exists = Notification::where('user_id', $validated['user_id'])
            ->where('title', $validated['title'])
            ->where('message', $validated['message'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if (!$exists) {
            Notification::create([
                'user_id'   => $validated['user_id'],
                'title'     => $validated['title'],
                'message'   => $validated['message'],
                'is_read'   => false,
                'created_by'=> 'admin',
            ]);

            return redirect()->route('admin.notifications.index')
                ->with('status', 'Thông báo đã được tạo thành công.');
        }

        return redirect()->route('admin.notifications.index')
            ->with('warning', 'Thông báo tương tự đã được gửi trong 5 phút qua. Hệ thống đã chặn thông báo trùng lặp.');
    }

    /**
     * Hiển thị form gửi thông báo hàng loạt.
     */
    public function createMassNotification()
    {
        return view('admin.notifications.mass-create');
    }

    /**
     * Gửi thông báo hàng loạt cho tất cả khách hàng đang hoạt động.
     */
    public function storeMassNotification(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::where('role', 'customer')
            ->where('status', 'active')
            ->get();

        $notificationCount = 0;
        $skippedCount = 0;

        foreach ($users as $user) {
            $exists = Notification::where('user_id', $user->id)
                ->where('title', $validated['title'])
                ->where('message', $validated['message'])
                ->where('created_at', '>', now()->subMinutes(5))
                ->exists();

            if (!$exists) {
                Notification::create([
                    'user_id'    => $user->id,
                    'title'      => $validated['title'],
                    'message'    => $validated['message'],
                    'is_read'    => false,
                    'created_by' => Auth::user()->role,
                ]);
                $notificationCount++;
            } else {
                $skippedCount++;
            }
        }

        $message = $skippedCount > 0
            ? "Đã gửi thông báo đến {$notificationCount} người dùng. Bỏ qua {$skippedCount} do trùng lặp."
            : "Thông báo đã được gửi đến tất cả {$notificationCount} người dùng thành công.";

        return redirect()->route('admin.notifications.index')->with('status', $message);
    }

    /**
     * Xóa một thông báo cụ thể.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('status', 'Thông báo đã được xóa thành công.');
    }

    /**
     * Xóa nhiều thông báo theo điều kiện lọc.
     */
    public function destroyAll(Request $request)
    {
        $query = Notification::query();
        $hasFilters = false;

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
            $hasFilters = true;
        }

        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read);
            $hasFilters = true;
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
            $hasFilters = true;
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
            $hasFilters = true;
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('message', 'LIKE', "%{$searchTerm}%");
            });
            $hasFilters = true;
        }

        $count = $query->count();
        $query->delete();

        $message = $count > 0
            ? ($hasFilters ? "Đã xóa thành công {$count} thông báo đã lọc." : "Đã xóa thành công tất cả {$count} thông báo.")
            : ($hasFilters ? "Không có thông báo nào phù hợp với bộ lọc để xóa." : "Không có thông báo nào để xóa.");

        return redirect()->route('admin.notifications.index')
            ->with('status', $message);
    }
}
