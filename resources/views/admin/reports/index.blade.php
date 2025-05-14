{{-- filepath: resources/views/admin/support/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Báo cáo thống kê')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-blue-800">Báo cáo thống kê</h1>
 <div>
    <a href="{{ route('admin.reports.export') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 via-green-600 to-green-700 text-white font-semibold rounded-lg shadow-lg hover:from-green-600 hover:to-green-800 transform transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50">
    <i class="fas fa-file-excel mr-3"></i> Xuất Excel
</a>
 </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-300 shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full shadow">
                <i class="fas fa-users text-blue-600 text-3xl"></i>
            </div>
            <div>
                <div class="text-white text-sm">Khách hàng</div>
                <div class="text-3xl font-bold text-white">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-300 shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full shadow">
                <i class="fas fa-user-tie text-green-600 text-3xl"></i>
            </div>
            <div>
                <div class="text-white text-sm">Nhân viên</div>
                <div class="text-3xl font-bold text-white">{{ $totalEmployees }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-300 shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full shadow">
                <i class="fas fa-file-contract text-yellow-600 text-3xl"></i>
            </div>
            <div>
                <div class="text-white text-sm">Hợp đồng</div>
                <div class="text-3xl font-bold text-white">{{ $totalContracts }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-300 shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full shadow">
                <i class="fas fa-coins text-purple-600 text-3xl"></i>
            </div>
            <div>
                <div class="text-white text-sm">Tổng doanh thu</div>
                <div class="text-3xl font-bold text-white">{{ number_format($totalRevenue, 0, ',', '.') }} VND</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold mb-4">Doanh thu theo tháng</h2>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold mb-4">Tỷ lệ hợp đồng theo trạng thái</h2>
            <canvas id="statusChart" height="120"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold mb-4">Top 5 dịch vụ phổ biến</h2>
            <ul class="divide-y divide-gray-200">
                @foreach($topServices as $service)
                    <li class="py-2 flex justify-between">
                        <span>{{ $service->service_name }}</span>
                        <span class="font-semibold">{{ $service->usage_count }} lần</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold mb-4">Top 5 khách hàng doanh thu cao</h2>
            <ul class="divide-y divide-gray-200">
                @foreach($topCustomers as $customer)
                    <li class="py-2 flex justify-between">
                        <span>{{ $customer->name }}</span>
                        <span class="font-semibold">{{ number_format($customer->total, 0, ',', '.') }} VND</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doanh thu theo tháng
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenueMonths) !!},
            datasets: [{
                label: 'Doanh thu (VND)',
                data: {!! json_encode($revenueValues) !!},
                backgroundColor: '#6366f1'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Tỷ lệ hợp đồng theo trạng thái
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($contractStatusLabels) !!},
            datasets: [{
                data: {!! json_encode($contractStatusValues) !!},
                backgroundColor: ['#22c55e', '#f59e42', '#ef4444', '#6366f1']
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush
@endsection