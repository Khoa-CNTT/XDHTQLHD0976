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

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Lấy thời gian lọc, mặc định là tháng hiện tại
        $period = $request->input('period', 'month');
        $now = Carbon::now();
        
        switch ($period) {
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $periodLabel = 'tuần này';
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $periodLabel = 'tháng này';
                break;
            case 'quarter':
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                $periodLabel = 'quý này';
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                $periodLabel = 'năm này';
                break;
            case 'all':
                $startDate = null;
                $endDate = null;
                $periodLabel = 'tất cả thời gian';
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $periodLabel = 'tháng này';
        }

        // Thống kê số lượng
        $totalCustomers = Customer::count();
        $totalEmployees = Employee::count();
        $totalContracts = Contract::count();
        $totalServices = Service::count();
        
        // Thống kê hợp đồng và thanh toán trong kỳ
        $contractsQuery = Contract::query();
        $paymentsQuery = Payment::query();
        
        if ($startDate && $endDate) {
            $contractsQuery->whereBetween('created_at', [$startDate, $endDate]);
            $paymentsQuery->whereBetween('date', [$startDate, $endDate]);
        }
        
        $periodContracts = $contractsQuery->count();
        $periodRevenue = $paymentsQuery->where('status', 'Hoàn Thành')->sum('amount');

        // Tổng doanh thu từ thanh toán
        $totalRevenue = Payment::where('status', 'Hoàn Thành')->sum('amount');

        // Hợp đồng theo trạng thái
        $contractsByStatus = Contract::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Thanh toán theo trạng thái
        $paymentsByStatus = Payment::selectRaw('status, COUNT(*) as count, SUM(amount) as total_amount')
            ->groupBy('status')
            ->get();

        // Thanh toán theo phương thức
        $paymentsByMethod = Payment::selectRaw('method, COUNT(*) as count, SUM(amount) as total_amount')
            ->where('status', 'Hoàn Thành')
            ->groupBy('method')
            ->get();

        // Doanh thu theo tháng (6 tháng gần nhất)
        $monthlyRevenue = Payment::where('status', 'Hoàn Thành')
            ->selectRaw('MONTH(date) as month, YEAR(date) as year, SUM(amount) as revenue')
            ->whereDate('date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                $month = Carbon::createFromDate($item->year, $item->month, 1);
                return [
                    'month_name' => $month->format('m/Y'),
                    'month_short' => $month->format('m/Y'),
                    'revenue' => $item->revenue
                ];
            });

        // Dịch vụ phổ biến nhất
        $popularServices = Service::selectRaw('services.service_name, COUNT(contracts.id) as usage_count, SUM(payments.amount) as total_revenue')
            ->join('contracts', 'services.id', '=', 'contracts.service_id')
            ->leftJoin('payments', 'contracts.id', '=', 'payments.contract_id')
            ->where('payments.status', 'Hoàn Thành')
            ->groupBy('services.id', 'services.service_name')
            ->orderByDesc('usage_count')
            ->limit(5)
            ->get();

        // Khách hàng có giá trị nhất
        $topCustomers = Customer::selectRaw('customers.id, users.name, COUNT(DISTINCT contracts.id) as contract_count, SUM(payments.amount) as total_spent')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->join('contracts', 'customers.id', '=', 'contracts.customer_id')
            ->leftJoin('payments', 'contracts.id', '=', 'payments.contract_id')
            ->where('payments.status', 'Hoàn Thành')
            ->groupBy('customers.id', 'users.name')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Tỉ lệ chuyển đổi hợp đồng
        $totalContractsWithPayments = Contract::whereHas('payments', function($query) {
            $query->where('status', 'Hoàn Thành');
        })->count();
        
        $conversionRate = $totalContracts > 0 ? ($totalContractsWithPayments / $totalContracts) * 100 : 0;

        // Thống kê xu hướng theo thời gian (tăng trưởng)
        $previousPeriod = [
            'start' => $startDate ? $startDate->copy()->subMonth() : Carbon::now()->subMonths(2)->startOfMonth(),
            'end' => $endDate ? $endDate->copy()->subMonth() : Carbon::now()->subMonth()->endOfMonth()
        ];
        
        $previousRevenue = Payment::where('status', 'Hoàn Thành')
            ->whereBetween('date', [$previousPeriod['start'], $previousPeriod['end']])
            ->sum('amount');
            
        $revenueGrowth = $previousRevenue > 0 ? (($periodRevenue - $previousRevenue) / $previousRevenue) * 100 : 100;

        $previousContractsCount = Contract::whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])->count();
        $contractsGrowth = $previousContractsCount > 0 ? (($periodContracts - $previousContractsCount) / $previousContractsCount) * 100 : 100;

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
            'periodRevenue',
            'periodContracts',
            'periodLabel',
            'period',
            'contractsByStatus',
            'paymentsByStatus',
            'paymentsByMethod',
            'monthlyRevenue',
            'popularServices',
            'topCustomers',
            'conversionRate',
            'revenueGrowth',
            'contractsGrowth',
            'employeesByDepartment'
        ));
    }
}