@extends('layouts.customer')

@section('title', 'Chi Tiết Thanh Toán')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
    @if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Chi Tiết Thanh Toán</h1>
        <a href="{{ route('customer.payments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Quay lại danh sách
        </a>
    </div>

    <!-- Thông tin giao dịch chính -->
    <div class="bg-blue-50 rounded-lg p-6 mb-8 border border-blue-200">
        <h2 class="text-xl font-semibold mb-4 text-blue-800">Thông Tin Giao Dịch</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-900">Mã giao dịch</label>
                <p class="mt-1 text-lg font-semibold text-gray-800">{{ $payment->transaction_id ?? 'Không có' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Số tiền</label>
                <p class="mt-1 text-lg font-semibold text-gray-800">{{ number_format($payment->amount, 0, ',', '.') }} VND</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Thời gian thanh toán</label>
                <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Phương thức thanh toán</label>
                <p class="mt-1 text-gray-600">{{ $payment->method }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Trạng thái</label>
                <p class="mt-1">
                    <span class="px-3 py-1 rounded-full text-sm inline-block 
                        {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-600' : 
                        ($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi' ? 'bg-yellow-100 text-yellow-600' : 
                        'bg-red-100 text-red-600') }}">
                        {{ $payment->status }}
                    </span>
                </p>
            </div>
            @if($payment->payment_type)
            <div>
                <label class="block text-sm font-medium text-gray-900">Loại thẻ/Phương thức</label>
                <p class="mt-1 text-gray-600">{{ $payment->payment_type }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Thông tin hợp đồng liên quan -->
    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4">Thông Tin Hợp Đồng</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-900">Mã hợp đồng</label>
                <p class="mt-1 text-gray-600">{{ $payment->contract->contract_number }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Dịch vụ</label>
                <p class="mt-1 text-gray-600">{{ $payment->contract->service->service_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Ngày bắt đầu</label>
                <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($payment->contract->start_date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900">Ngày kết thúc</label>
                <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($payment->contract->end_date)->format('d/m/Y') }}</p>
            </div>
            <div class="md:col-span-2">
                <a href="{{ route('customer.contracts.show', $payment->contract->id) }}" 
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Xem chi tiết hợp đồng
                </a>
            </div>
        </div>
    </div>

    <!-- Chi tiết kỹ thuật thanh toán -->
    @if($payment->status === 'Hoàn Thành')
    <div class="border border-gray-200 rounded-lg overflow-hidden">
        <div class="flex items-center justify-between bg-gray-100 px-6 py-3 cursor-pointer" 
             onclick="document.getElementById('techDetails').classList.toggle('hidden')">
            <h3 class="text-lg font-medium text-gray-900">Chi tiết kỹ thuật</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
        <div id="techDetails" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-900">Order ID</label>
                    <p class="mt-1 text-gray-600">{{ $payment->order_id }}</p>
                </div>
                @if($payment->transaction_id)
                <div>
                    <label class="block text-sm font-medium text-gray-900">Transaction ID</label>
                    <p class="mt-1 text-gray-600">{{ $payment->transaction_id }}</p>
                </div>
                @endif
            </div>
            
            @if($payment->payment_response)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Thông tin phản hồi</label>
                    <div class="bg-gray-100 p-4 rounded overflow-auto max-h-64">
                        <pre class="text-xs">{{ json_encode(json_decode($payment->payment_response), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Nút tải xuống hóa đơn nếu thanh toán thành công -->
    @if($payment->status === 'Hoàn Thành')
    <div class="mt-8 flex justify-center">
        <a href="{{ route('customer.payments.download', $payment->id) }}" 
           class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Tải hóa đơn thanh toán
        </a>
    </div>
    @endif
</div>
@endsection 