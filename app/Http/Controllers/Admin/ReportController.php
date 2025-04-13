<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Service;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê số lượng
        $totalCustomers = Customer::count();
        $totalEmployees = Employee::count();
        $totalContracts = Contract::count();
        $totalServices = Service::count();

        // Tổng doanh thu từ hợp đồng
        $totalRevenue = Contract::where('status', 'Hoàn thành')->sum('total_price');

        // Hợp đồng theo trạng thái
        $contractsByStatus = Contract::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Doanh thu theo tháng
        $monthlyRevenue = Contract::where('status', 'Hoàn thành')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->get();

        // Dịch vụ phổ biến nhất
        $popularServices = Service::selectRaw('service_name, COUNT(contracts.id) as usage_count')
            ->join('contracts', 'services.id', '=', 'contracts.service_id')
            ->groupBy('services.id', 'services.service_name')
            ->orderByDesc('usage_count')
            ->limit(5)
            ->get();

        // Nhân viên theo phòng ban
        $employeesByDepartment = Employee::selectRaw('department, COUNT(*) as count')
            ->groupBy('department')
            ->get();

        return view('admin.reports.index', compact(
            'totalCustomers',
            'totalEmployees',
            'totalContracts',
            'totalServices',
            'totalRevenue',
            'contractsByStatus',
            'monthlyRevenue',
            'popularServices',
            'employeesByDepartment'
        ));
    }
}