<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\SupportTicket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng số người dùng
        $totalUsers = User::count();

        // Người dùng mới trong tháng này
        $newUsers = User::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->count();

        // Người dùng hoạt động (đăng nhập trong 30 ngày gần nhất)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))->count();

        // Tổng số hợp đồng
        $totalContracts = Contract::count();

        // Hợp đồng mới trong tháng này
        $newContracts = Contract::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();

        // Tổng doanh thu
        $totalRevenue = Contract::sum('total_price');

        // Tổng số ticket hỗ trợ
        $supportTickets = SupportTicket::count();

        // Biểu đồ doanh thu theo tháng (12 tháng gần nhất)
        $revenueChartLabels = [];
        $revenueChartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $label = $month->format('m/Y');
            $revenue = Contract::whereYear('created_at', $month->year)
                               ->whereMonth('created_at', $month->month)
                               ->sum('total_price');
            $revenueChartLabels[] = $label;
            $revenueChartData[] = $revenue;
        }

        // Biểu đồ trạng thái hợp đồng
        $contractStatusLabels = ['Hoàn thành', 'Đang hoạt động', 'Đã huỷ', 'Chờ xử lý'];
        $contractStatusData = [
            Contract::where('status', 'Hoàn thành')->count(),
            Contract::where('status', 'Đang hoạt động')->count(),
            Contract::where('status', 'Đã huỷ')->count(),
            Contract::where('status', 'Chờ xử lý')->count(),
        ];

        // Danh sách hoạt động gần đây (ví dụ: 10 hoạt động gần nhất)
        $recentActivities = Contract::with('customer.user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($contract) {
                return [
                    'user' => optional(optional($contract->customer)->user)->name ?? 'Không xác định',
                    'action' => 'Tạo hợp đồng',
                    'time' => $contract->created_at->format('d/m/Y H:i'),
                ];
            });

        // Ticket hỗ trợ gần đây
        $recentTickets = SupportTicket::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($ticket) {
                return [
                    'user' => optional($ticket->user)->name ?? 'Không xác định',
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'time' => $ticket->created_at->format('d/m/Y H:i'),
                ];
            });

        // Hiệu suất hệ thống (giả lập)
        $systemStatus = [
            'server' => 'Hoạt động',
            'api' => 'Hoạt động',
            'database' => 'Hoạt động',
        ];
        $systemErrors = [
            ['error' => 'Timeout API', 'time' => '2025-05-16 14:00'],
            ['error' => 'Lỗi kết nối DB', 'time' => '2025-05-15 10:00'],
        ];
        $notifications = [
            ['content' => 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025', 'created_at' => '2025-05-18 10:00'],
        ];
        $upcomingEvents = [
            ['title' => 'Họp quản trị', 'time' => '2025-05-21 09:00'],
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsers',
            'activeUsers',
            'totalContracts',
            'newContracts',
            'totalRevenue',
            'supportTickets',
            'revenueChartLabels',
            'revenueChartData',
            'contractStatusLabels',
            'contractStatusData',
            'recentActivities',
            'recentTickets',
            'systemStatus',
            'systemErrors',
            'notifications',
            'upcomingEvents'
        ));
    }
}