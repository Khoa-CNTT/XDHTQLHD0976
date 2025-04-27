@extends('layouts.customer')

@section('title', 'Thanh Toán Hợp Đồng')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
    <h1 class="text-2xl font-bold mb-6 text-center">Thanh Toán Hợp Đồng</h1>

    <!-- Thông tin đơn hàng -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold">Thông tin đơn hàng</h3>
        <p class="text-gray-600">Nhà cung cấp: <strong>MoMo Demo</strong></p>
        <p class="text-gray-600">Mã đơn hàng: <strong>{{ $orderId }}</strong></p>
        <p class="text-gray-600">Mô tả: <strong>Thanh toán hợp đồng #{{ $contract->id }}</strong></p>
        <p class="text-gray-600">Số tiền: <strong>{{ number_format($contract->total_price, 0, ',', '.') }} VND</strong></p>
    </div>

    <!-- QR Code -->
    @if ($qrCodeUrl)
<div class="mb-6 text-center">
    <h3 class="text-xl font-semibold">Quét mã QR để thanh toán</h3>
    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="mx-auto my-4 w-64 h-64">
    <p class="text-gray-600">Sử dụng App MoMo hoặc ứng dụng ngân hàng để quét mã</p>
</div>
@endif

    <!-- Nút thanh toán -->
    <div class="mb-6 text-center">
        <a href="{{ $payUrl }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Thanh Toán Ngay
        </a>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-6 text-center">
        <a href="{{ route('customer.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Quay lại danh sách hợp đồng
        </a>
    </div>
</div>
@endsection