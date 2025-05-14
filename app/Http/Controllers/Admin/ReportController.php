<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    
     public function exportToExcel()
    {
        
        return Excel::download(new ReportExport(), 'contracts_report.xlsx');
    }
    function index(Request $request)
{
     // Tổng số khách hàng
    $totalCustomers = \App\Models\Customer::count();
    // Tổng số nhân viên
    $totalEmployees = \App\Models\Employee::count();
    // Tổng số hợp đồng
    $totalContracts = \App\Models\Contract::count();
    // Tổng doanh thu
    $totalRevenue = \App\Models\Contract::sum('total_price');

    // Lấy top 5 dịch vụ phổ biến
    $topServices = \App\Models\Service::withCount('contracts')
        ->orderByDesc('contracts_count')
        ->take(5)
        ->get()
        ->map(function($service) {
            return (object)[
                'service_name' => $service->service_name,
                'usage_count' => $service->contracts_count
            ];
        });

    // Lấy top 5 khách hàng doanh thu cao nhất
    $topCustomers = \App\Models\Customer::with('user')
        ->withSum('contracts as total', 'total_price')
        ->orderByDesc('total')
        ->take(5)
        ->get()
        ->map(function($customer) {
            return (object)[
                'name' => optional($customer->user)->name,
                'total' => $customer->total
            ];
        });

    // Doanh thu theo tháng (ví dụ 6 tháng gần nhất)
    $revenueMonths = [];
    $revenueValues = [];
    foreach (range(5, 0) as $i) {
        $month = now()->subMonths($i)->format('m/Y');
        $revenue = \App\Models\Contract::whereYear('created_at', now()->subMonths($i)->year)
            ->whereMonth('created_at', now()->subMonths($i)->month)
            ->sum('total_price');
        $revenueMonths[] = $month;
        $revenueValues[] = $revenue;
    }

    // Tỷ lệ hợp đồng theo trạng thái
    $contractStatusLabels = ['Hoàn thành', 'Hoạt động', 'Chờ xử lý', 'Đã huỷ'];
    $contractStatusValues = [
        \App\Models\Contract::where('status', 'Hoàn thành')->count(),
        \App\Models\Contract::where('status', 'Hoạt động')->count(),
        \App\Models\Contract::where('status', 'Chờ xử lý')->count(),
        \App\Models\Contract::where('status', 'Đã huỷ')->count(),
    ];

    return view('admin.reports.index', compact(
        'totalCustomers',
        'totalEmployees',
        'totalContracts',
        'totalRevenue',
        'topServices',
        'topCustomers',
        'revenueMonths',
        'revenueValues',
        'contractStatusLabels',
        'contractStatusValues'
    ));
}
}