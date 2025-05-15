<?php

namespace App\Http\Controllers\Employee;

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
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }
        
       $query = SupportTicket::with('user')
        ->where('assigned_employee_id', Auth::id());
        
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
        
       $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        $customers = User::where('role', 'customer')->get();
        return view('admin.support.index', compact('tickets', 'customers'));
    }
    
   public function show($id)
{
    if (!Auth::user()->isEmployee()) {
        return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
    }

    $ticket = SupportTicket::with(['user', 'responses' => function($query) {
        $query->orderBy('created_at', 'asc');
    }])
    ->where('assigned_employee_id', Auth::id())
    ->findOrFail($id);

    return view('admin.support.show', compact('ticket'));
}
    
    public function update(Request $request, $id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }
        
        $ticket = SupportTicket::findOrFail($id);
        
       $validator = Validator::make($request->all(), [
    'status' => 'required|in:Đang xử lý,Đã giải quyết,Đã huỷ',
]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Trạng thái không hợp lệ');
        }
        
        $ticket->status = $request->status;
        $ticket->save();
        
    if ($ticket->status === 'Đã giải quyết') {
        $message = 'Yêu cầu đã giải quyết thành công';
    } elseif ($ticket->status === 'Đã huỷ') {
        $message = 'Yêu cầu đã huỷ';
    } else {
        $message = 'Cập nhật trạng thái yêu cầu hỗ trợ thành công';
    }

        return redirect()->back()->with('success', $message);
    }
    public function respond(Request $request, $id)
{
    if (!Auth::user()->isEmployee()) {
        return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
    }

    $ticket = SupportTicket::where('assigned_employee_id', Auth::id())->findOrFail($id);
    $this->authorize('respond', $ticket);

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

    $response = new \App\Models\SupportResponse([
        'support_ticket_id' => $ticket->id,
        'user_id' => Auth::id(),
        'content' => $request->response,
    ]);
    $response->save();

    if ($ticket->status === 'Đang xử lý') {
        $ticket->status = 'Đang xử lý';
        $ticket->save();
    }

  

    return redirect()->back()->with('success', 'Đã gửi phản hồi thành công');
}
} 