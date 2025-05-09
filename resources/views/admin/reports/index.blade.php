@extends('layouts.admin')

@section('title', 'Báo cáo thống kê')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Báo cáo thống kê</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tổng số khách hàng</h2>
            <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tổng số nhân viên</h2>
            <p class="text-2xl font-bold">{{ $totalEmployees }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tổng số hợp đồng</h2>
            <p class="text-2xl font-bold">{{ $totalContracts }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tổng số dịch vụ</h2>
            <p class="text-2xl font-bold">{{ $totalServices }}</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tổng doanh thu</h2>
            <p class="text-2xl font-bold">{{ number_format($totalRevenue, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <h2 class="text-xl font-bold mt-8 mb-4">Hợp đồng theo trạng thái</h2>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">Trạng thái</th>
                <th class="px-4 py-2">Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contractsByStatus as $status)
                <tr>
                    <td class="border px-4 py-2">{{ $status->status }}</td>
                    <td class="border px-4 py-2">{{ $status->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-bold mt-8 mb-4">Doanh thu theo tháng</h2>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">Tháng</th>
                <th class="px-4 py-2">Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyRevenue as $revenue)
                <tr>
                    <td class="border px-4 py-2">{{ $revenue['month_name'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($revenue['revenue'], 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-bold mt-8 mb-4">Dịch vụ phổ biến nhất</h2>
    <ul class="list-disc pl-6">
        @foreach($popularServices as $service)
            <li>{{ $service->service_name }} ({{ $service->usage_count }} lần sử dụng)</li>
        @endforeach
    </ul>

    <h2 class="text-xl font-bold mt-8 mb-4">Nhân viên theo phòng ban</h2>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">Phòng ban</th>
                <th class="px-4 py-2">Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employeesByDepartment as $department)
                <tr>
                    <td class="border px-4 py-2">{{ $department->department }}</td>
                    <td class="border px-4 py-2">{{ $department->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection