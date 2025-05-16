<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportResponse;  
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class SupportTicketController extends Controller
{
   public function index(Request $request)
{
    $user = auth()->user();
    $tickets = SupportTicket::query()->with('user');

    // Nếu là nhân viên chỉ xem ticket được giao
    if ($user->role === 'employee') {
        $tickets->where('assigned_employee_id', $user->id);
    }

    // Lọc theo tên hoặc tiêu đề
    if ($request->filled('search')) {
        $search = $request->search;
        $tickets->where(function($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhereHas('user', function($u) use ($search) {
                  $u->where('name', 'like', "%$search%");
              });
        });
    }

    // Lọc theo trạng thái
    if ($request->filled('status')) {
        $tickets->where('status', $request->status);
    }

    // Lọc theo khách hàng
    if ($request->filled('user_id')) {
        $tickets->where('user_id', $request->user_id);
    }

    $tickets = $tickets->orderByDesc('created_at')->paginate(10);
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
    $this->authorize('update', $ticket);

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
   $ticket = SupportTicket::findOrFail($id);
    $this->authorize('respond', $ticket);
    

    $request->validate([
        'response' => 'required|string',
    ]);

    $response = new SupportResponse([
        'support_ticket_id' => $ticket->id,
        'user_id' => Auth::id(),
        'content' => $request->response,
    ]);
    $response->save();

    // Cập nhật trạng thái ticket
    if ($ticket->status === 'Đang xử lý') {
        $ticket->status = 'Đang xử lý';
        $ticket->save();
    }

    return redirect()->back()->with('success', 'Đã gửi phản hồi thành công');
}


  


    /**
     * Kiểm tra trạng thái đang gõ của khách hàng
     */
    public function checkTypingStatus($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        // Kiểm tra xem khách hàng có đang gõ không
        $isTyping = Cache::has("user_{$ticket->user_id}_typing_ticket_{$id}");

        return response()->json([
            'typing' => $isTyping
        ]);
    }

    /**
     * Kiểm tra và lấy các phản hồi mới từ khách hàng
     */
    public function checkNewResponses(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $lastId = $request->input('last_id', 0);

        // Lấy các phản hồi mới hơn ID cuối cùng đã hiển thị
        $responses = $ticket->responses()
            ->where('id', '>', $lastId)
            ->where('user_id', $ticket->user_id) // Chỉ lấy phản hồi từ khách hàng
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
                'is_staff' => false
            ];
        });

        return response()->json([
            'success' => true,
            'responses' => $formattedResponses
        ]);
    }
}
