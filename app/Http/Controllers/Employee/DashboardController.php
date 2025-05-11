<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Service;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        // Tổng số hợp đồng
        $contractCount = Contract::count();
        
        // Tổng số yêu cầu hỗ trợ đang chờ
        $pendingTicketsCount = SupportTicket::where('status', 'Chờ xử lý')->count();
        
        // Hợp đồng mới nhất
        $latestContracts = Contract::with('customer', 'service')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Yêu cầu hỗ trợ mới nhất
        $latestTickets = SupportTicket::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Tổng số thanh toán hoàn thành
        $completedPaymentsCount = Payment::where('status', 'Hoàn Thành')->count();
        
        // Trả về view với dữ liệu
        return view('admin.dashboard', compact(
            'contractCount',
            'pendingTicketsCount',
            'latestContracts',
            'latestTickets',
            'completedPaymentsCount'
        ));
    }
} 