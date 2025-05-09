@extends('layouts.admin')

@section('title', 'Chi Tiết Thanh Toán')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Chi Tiết Thanh Toán #{{ $payment->id }}</h1>
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại
        </a>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Thông tin thanh toán -->
        <div class="lg:col-span-2">
            <div class="border border-gray-200 rounded-lg shadow-sm">
                <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Thông Tin Thanh Toán
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Mã giao dịch:</p>
                            <p class="text-gray-800">{{ $payment->transaction_id ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Số tiền:</p>
                            <p class="text-lg font-semibold text-blue-600">{{ number_format($payment->amount, 0, ',', '.') }} VND</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Phương thức thanh toán:</p>
                            <p class="text-gray-800">{{ $payment->method }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Thời gian thanh toán:</p>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Trạng thái:</p>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-800' : 
                                ($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800') }}">
                                {{ $payment->status }}
                            </span>
                        </div>
                        @if($payment->payment_type)
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Loại thẻ/Phương thức:</p>
                            <p class="text-gray-800">{{ $payment->payment_type }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Form cập nhật trạng thái thanh toán -->
                    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="border-t border-gray-200 pt-4">
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Cập nhật trạng thái:</label>
                                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Hoàn Thành" {{ $payment->status == 'Hoàn Thành' ? 'selected' : '' }}>Hoàn Thành</option>
                                    <option value="Đang Xử Lý" {{ $payment->status == 'Đang Xử Lý' ? 'selected' : '' }}>Đang Xử Lý</option>
                                    <option value="Thất Bại" {{ $payment->status == 'Thất Bại' ? 'selected' : '' }}>Thất Bại</option>
                                    <option value="Đang Đợi" {{ $payment->status == 'Đang Đợi' ? 'selected' : '' }}>Đang Đợi</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú:</label>
                                <textarea name="notes" id="notes" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3">{{ $payment->notes ?? '' }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Thông tin hợp đồng liên quan -->
        <div>
            <div class="border border-gray-200 rounded-lg shadow-sm">
                <div class="bg-cyan-600 text-white px-4 py-3 rounded-t-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Thông Tin Hợp Đồng
                </div>
                <div class="p-4">
                    @if($payment->contract)
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Mã hợp đồng:</p>
                            <a href="{{ route('admin.contracts.show', $payment->contract->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                {{ $payment->contract->contract_number }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Khách hàng:</p>
                            <p class="text-gray-800">{{ $payment->contract->customer->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Email:</p>
                            <p class="text-gray-800">{{ $payment->contract->customer->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Dịch vụ:</p>
                            <p class="text-gray-800">{{ $payment->contract->service->service_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Thời hạn hợp đồng:</p>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($payment->contract->start_date)->format('d/m/Y') }} - 
                               {{ \Carbon\Carbon::parse($payment->contract->end_date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="pt-3 mt-3 border-t border-gray-200">
                            <a href="{{ route('admin.contracts.show', $payment->contract->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Xem chi tiết hợp đồng
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Không tìm thấy thông tin hợp đồng liên quan
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin kỹ thuật -->
    <div class="border border-gray-200 rounded-lg shadow-sm mb-6">
        <div class="bg-gray-600 text-white px-4 py-3 rounded-t-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            Thông Tin Kỹ Thuật
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Order ID:</p>
                    <p class="text-gray-800">{{ $payment->order_id ?? 'Không có' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Transaction ID:</p>
                    <p class="text-gray-800">{{ $payment->transaction_id ?? 'Không có' }}</p>
                </div>
            </div>

            @if($payment->payment_response)
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Thông tin phản hồi:</p>
                <div class="mt-2 bg-gray-50 rounded p-3 max-h-64 overflow-y-auto">
                    <pre class="text-xs text-gray-800 whitespace-pre-wrap">{{ json_encode(json_decode($payment->payment_response), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Hành động -->
    <div class="border border-gray-200 rounded-lg shadow-sm">
        <div class="bg-gray-800 text-white px-4 py-3 rounded-t-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            Hành Động
        </div>
        <div class="p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Danh sách thanh toán
                </a>
                @if($payment->status === 'Hoàn Thành')
                <button onclick="window.print();" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    In biên lai
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 