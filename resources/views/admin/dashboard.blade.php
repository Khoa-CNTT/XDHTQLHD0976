{{-- filepath: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">

    {{-- Tổng quan --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-500 text-white rounded-lg p-6 shadow flex flex-col items-center">
            <div class="text-2xl font-bold">{{ $totalUsers }}</div>
            <div class="text-sm mt-2">Tổng số người dùng</div>
        </div>
        <div class="bg-green-500 text-white rounded-lg p-6 shadow flex flex-col items-center">
            <div class="text-2xl font-bold">{{ $newUsers }}</div>
            <div class="text-sm mt-2">Người dùng mới</div>
        </div>
        <div class="bg-yellow-500 text-white rounded-lg p-6 shadow flex flex-col items-center">
            <div class="text-2xl font-bold">{{ $activeUsers }}</div>
            <div class="text-sm mt-2">Người dùng hoạt động</div>
        </div>
        <div class="bg-purple-500 text-white rounded-lg p-6 shadow flex flex-col items-center">
            <div class="text-2xl font-bold">{{ $totalRevenue ? number_format($totalRevenue, 0, ',', '.') : 0 }} VND</div>
            <div class="text-sm mt-2">Tổng doanh thu</div>
        </div>
    </div>

    {{-- Biểu đồ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Doanh thu theo tháng</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Tỷ lệ hợp đồng theo trạng thái</h3>
            <canvas id="contractStatusChart"></canvas>
        </div>
    </div>

    {{-- Danh sách hoạt động --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Hoạt động gần đây</h3>
            <ul>
                @foreach($recentActivities as $activity)
                    <li class="mb-2">
                        <span class="font-bold">{{ $activity['user'] }}</span> - {{ $activity['action'] }}
                        <span class="text-xs text-gray-500">({{ $activity['time'] }})</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Ticket hỗ trợ gần đây</h3>
            <ul>
                @foreach($recentTickets as $ticket)
                    <li class="mb-2">
                        <span class="font-bold">{{ $ticket['user'] }}</span> - {{ $ticket['subject'] }}
                        <span class="text-xs text-gray-500">({{ $ticket['status'] }} - {{ $ticket['time'] }})</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Quản lý hệ thống --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Hiệu suất hệ thống</h3>
            <ul>
                <li>Server: <span class="font-bold text-green-600">{{ $systemStatus['server'] }}</span></li>
                <li>API: <span class="font-bold text-green-600">{{ $systemStatus['api'] }}</span></li>
                <li>Database: <span class="font-bold text-green-600">{{ $systemStatus['database'] }}</span></li>
            </ul>
            <h4 class="mt-4 font-semibold">Lỗi hệ thống gần đây</h4>
            <ul>
                @foreach($systemErrors as $error)
                    <li class="text-red-600 text-sm">{{ $error['error'] }} ({{ $error['time'] }})</li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Thông báo & Sự kiện</h3>
            <ul>
                @foreach($notifications as $noti)
                    <li class="mb-2 text-blue-700">{{ $noti['content'] }} <span class="text-xs text-gray-500">({{ $noti['created_at'] }})</span></li>
                @endforeach
            </ul>
            <h4 class="mt-4 font-semibold">Sự kiện sắp tới</h4>
            <ul>
                @foreach($upcomingEvents as $event)
                    <li class="text-green-700 text-sm">{{ $event['title'] }} ({{ $event['time'] }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ doanh thu
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenueChartLabels) !!},
            datasets: [{
                label: 'Doanh thu (VND)',
                data: {!! json_encode($revenueChartData) !!},
                backgroundColor: '#6366f1'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Biểu đồ trạng thái hợp đồng
    new Chart(document.getElementById('contractStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($contractStatusLabels) !!},
            datasets: [{
                data: {!! json_encode($contractStatusData) !!},
                backgroundColor: ['#22c55e', '#f59e42', '#ef4444', '#6366f1']
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush
@endsection