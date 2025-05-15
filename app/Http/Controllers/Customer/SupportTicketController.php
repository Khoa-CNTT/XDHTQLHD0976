<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportResponse;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;



class SupportTicketController extends Controller
{
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

        $user = Auth::user();
     // Tìm nhân viên có ít ticket "Đang xử lý" nhất
    $employee = \App\Models\User::where('role', 'employee')
        ->withCount(['assignedTickets' => function($q) {
            $q->where('status', 'Đang xử lý');
        }])
        ->orderBy('assigned_tickets_count', 'asc')
        ->first();

       $ticket = new \App\Models\SupportTicket([
        'title' => $request->title,
        'content' => $request->content,
        'status' => 'Đang xử lý',
        'assigned_employee_id' => $employee ? $employee->id : null,
        'user_id' => Auth::id(),
    ]);
    $ticket->save();
        
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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập nội dung phản hồi'
                ]);
            }
            
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
        
        // Xử lý phản hồi AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã gửi phản hồi thành công',
                'response' => [
                    'id' => $response->id,
                    'content' => nl2br(e($response->content)),
                    'user_name' => $user->name,
                    'user_avatar' => $response->user->getAvatarUrl(),
                    'created_at' => $response->created_at->format('d/m/Y H:i'),
                    'is_staff' => false
                ]
            ]);
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
    
    /**
     * Cập nhật trạng thái đang gõ của người dùng
     */
    public function updateTypingStatus(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'typing' => 'required|boolean'
        ]);
        
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);
       
        if ($request->typing) {
            Cache::put("user_{$user->id}_typing_ticket_{$id}", true, now()->addMinutes(1));
        } else {
            Cache::forget("user_{$user->id}_typing_ticket_{$id}");
        }
        
        // Broadcast một sự kiện để admin/nhân viên có thể thấy trạng thái gõ
        // Đây là nơi bạn có thể thêm code để gửi thông báo real-time qua WebSockets hoặc Pusher
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Kiểm tra và lấy các phản hồi mới
     */
    public function checkNewResponses(Request $request, $id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);
        
        $lastId = $request->input('last_id', 0);
        
        // Lấy các phản hồi mới hơn ID cuối cùng đã hiển thị
        $responses = $ticket->responses()
            ->where('id', '>', $lastId)
            ->where('user_id', '!=', $user->id) // Chỉ lấy phản hồi từ admin/nhân viên
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Chuẩn bị dữ liệu phản hồi
        $formattedResponses = $responses->map(function ($response) {
            return [
                'id' => $response->id,
                'content' => nl2br(e($response->content)),
                'user_name' => $response->user->name,
                'user_avatar' => $response->user->getAvatarUrl(),
                'created_at' => $response->created_at->format('d/m/Y H:i'),
                'is_staff' => $response->isStaff()
            ];
        });
        
        return response()->json([
            'success' => true,
            'responses' => $formattedResponses
        ]);
    }
    
    /**
     * Đóng yêu cầu hỗ trợ
     */
    public function closeSupportTicket($id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);
        
       $ticket->status = 'Đã đóng'; 
$ticket->save();
        
        // Ghi log hoạt động
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Đóng yêu cầu hỗ trợ',
            'description' => 'Bạn đã đóng yêu cầu hỗ trợ #' . $ticket->id . ': ' . $ticket->title
        ]);
        
        // Tạo thông báo cho admin và nhân viên
        $admins = User::whereIn('role', ['admin', 'employee'])->get();
        foreach ($admins as $admin) {
            $notification = new Notification([
                'user_id' => $admin->id,
                'title' => 'Yêu cầu hỗ trợ đã được đóng',
                'message' => 'Khách hàng "' . $user->name . '" đã đóng yêu cầu hỗ trợ #' . $ticket->id,
                'is_read' => false
            ]);
            
            $notification->save();
        }
        
        return redirect()->route('customer.support.index')->with('success', 'Yêu cầu hỗ trợ đã được đóng thành công');
    }
}