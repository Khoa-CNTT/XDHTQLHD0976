<!-- filepath: c:\Users\ASUS_TUF\Documents\QuanLyHopDong\ConT_management\resources\views\customer\contracts\show.blade.php -->
@extends('layouts.customer')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4">Chi Tiết Hợp Đồng</h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <p><strong>Mã Hợp Đồng:</strong> {{ $contract->contract_number }}</p>
        <p><strong>Dịch Vụ:</strong> {{ $contract->service->service_name }}</p>
        <p><strong>Ngày Bắt Đầu:</strong> {{ $contract->start_date }}</p>
        <p><strong>Ngày Kết Thúc:</strong> {{ $contract->end_date }}</p>
        <p><strong>Tổng Tiền:</strong> {{ number_format($contract->total_price, 0, ',', '.') }} đ</p>
        <p><strong>Nội Dung:</strong></p>
        <div class="border p-3 bg-gray-50 rounded">{{ $contract->content }}</div>
    </div>

    @if(!$contract->is_signed)
    <div class="mt-6">
        <form action="{{ route('customer.contracts.sign', $contract->id) }}" method="POST" class="mb-4">
            @csrf
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Nhập mã OTP để ký hợp đồng:</label>
            <input type="text" name="otp" id="otp" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-4" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Xác Nhận Ký</button>
        </form>

        <form action="{{ route('customer.contracts.sendOtp', $contract->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Gửi Lại OTP</button>
        </form>
    </div>
    @else
    <div class="mt-6 bg-green-100 text-green-700 p-4 rounded">
        Bạn đã ký hợp đồng này vào {{ $contract->signed_at->format('d/m/Y H:i') }}.
    </div>
    @endif
</div>
@endsection