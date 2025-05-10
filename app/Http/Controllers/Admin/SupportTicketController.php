<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');
        
        // Tìm kiếm theo tiêu đề hoặc nội dung
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo khách hàng
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }
        
        // Sắp xếp theo thời gian, mới nhất lên đầu
        $query->orderBy('created_at', 'desc');
        
        $tickets = $query->paginate(10);
        $customers = User::where('role', 'customer')->get();
        
        return view('admin.support.index', compact('tickets', 'customers'));
    }
    
    public function show($id)
    {
        $ticket = SupportTicket::with(['user', 'responses' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($id);
        
        return view('admin.support.show', compact('ticket'));
    }
    
    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Chờ xử lý,Đang xử lý,Đã giải quyết,Đã huỷ',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Trạng thái không hợp lệ');
        }
        
        $ticket->status = $request->status;
        $ticket->save();
        
        return redirect()->back()->with('success', 'Cập nhật trạng thái yêu cầu hỗ trợ thành công');
    }
    
    public function respond(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        
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
        
        // Tạo phản hồi mới
        $response = new \App\Models\SupportResponse([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(), // ID của nhân viên/admin đang đăng nhập
            'content' => $request->response,
        ]);
        
        $response->save();
        
        // Nếu trạng thái vẫn là "Chờ xử lý", cập nhật thành "Đang xử lý"
        if ($ticket->status === 'Chờ xử lý') {
            $ticket->status = 'Đang xử lý';
            $ticket->save();
        }
        
        // Tạo thông báo cho khách hàng
        $user = $ticket->user;
        $notification = new \App\Models\Notification([
            'user_id' => $user->id,
            'title' => 'Phản hồi yêu cầu hỗ trợ',
            'message' => 'Yêu cầu hỗ trợ "' . $ticket->title . '" đã được phản hồi.',
            'is_read' => false
        ]);
        
        $notification->save();
        
        return redirect()->back()->with('success', 'Đã gửi phản hồi thành công');
    }
} 