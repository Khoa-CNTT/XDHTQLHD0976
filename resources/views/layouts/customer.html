@extends('layouts.customer')

@section('title', 'Chi Tiết Hợp Đồng')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
    <h1 class="text-2xl font-bold mb-6 text-center">Chi Tiết Hợp Đồng</h1>

    <!-- Thông tin dịch vụ -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Dịch vụ</h3>
        <p class="text-gray-600">Tên dịch vụ: {{ $contract->service->service_name }}</p>
        <p class="text-gray-600">Loại dịch vụ: {{ $contract->service->service_type }}</p>
        <p class="text-gray-600">Giá: {{ number_format($contract->service->price, 0, ',', '.') }} VND</p>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Thông tin khách hàng</h3>
        @if ($contract->customer)
            <p class="text-gray-600">Tên: {{ $contract->customer->user->name }}</p>
            <p class="text-gray-600">Email: {{ $contract->customer->user->email }}</p>
            <p class="text-gray-600">Số điện thoại: {{ $contract->customer->user->phone }}</p>
            <p class="text-gray-600">Địa chỉ: {{ $contract->customer->user->address }}</p>
        @else
            <p class="text-gray-600 text-red-500">Thông tin khách hàng không khả dụng.</p>
        @endif
    </div>

    <!-- Thông tin hợp đồng -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Thông tin hợp đồng</h3>
        <p class="text-gray-600">Ngày bắt đầu: {{ $contract->start_date }}</p>
        <p class="text-gray-600">Trạng thái: 
            <span class="px-3 py-1 rounded-full text-sm inline-block
                @if ($contract->status === 'Chờ xử lý') bg-yellow-100 text-yellow-600
                @elseif ($contract->status === 'Hoàn thành') bg-blue-100 text-blue-600
                @elseif ($contract->status === 'Đã huỷ') bg-red-100 text-red-600
                @endif">
                {{ $contract->status }}
            </span>
        </p>
        @foreach ($contract->signatures as $signature)
        <p class="text-gray-600">Thời hạn: {{ $signature->duration }}</p>
        @endforeach
    </div>
        <p class="text-gray-600">Tổng giá trị hợp đồng: {{ number_format($contract->total_price, 0, ',', '.') }} VND</p>
    </div>
</div>
@endsection