@extends('layouts.customer')

@section('title', 'Lịch sử thanh toán')

@section('content')
<div class="max-w-5xl mx-auto mt-10 min-h-screen pb-24">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 mb-10">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Lịch sử thanh toán</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-left px-3 py-1 text-sm">
                        <th class="p-3">Mã giao dịch</th>
                        <th class="p-3">Ngày thanh toán</th>
                        <th class="p-3">Số tiền</th>
                        <th class="p-3">Phương thức</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                    <tr class="border-b">
                        <td class="p-3">{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td class="p-3">{{ $payment->date->format('d/m/Y H:i:s') }}</td>
                        <td class="p-3">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                        <td class="p-3">{{ $payment->method }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-sm inline-block
                                {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-600' : 
                                ($payment->status === 'Đang Xử Lý' ? 'bg-yellow-100 text-yellow-600' : 
                                'bg-red-100 text-red-600') }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <a href="{{ route('customer.payments.show', $payment->id) }}" 
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-medium">Không có dữ liệu thanh toán.</p>
                                <p class="text-gray-400 mt-2">Các giao dịch thanh toán của bạn sẽ xuất hiện ở đây.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>

    <!-- Thêm phần thông tin về thanh toán -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-20">
        <h3 class="text-xl font-bold text-blue-800 mb-4">Thông tin về thanh toán</h3>
        
        <div class="grid md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="font-medium">Thanh toán an toàn</h4>
                </div>
                <p class="text-sm text-gray-600">Tất cả các giao dịch đều được bảo mật và xử lý qua cổng thanh toán tin cậy.</p>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h4 class="font-medium">Hóa đơn điện tử</h4>
                </div>
                <p class="text-sm text-gray-600">Mỗi giao dịch đều có hóa đơn điện tử đi kèm, bạn có thể tải về và lưu trữ.</p>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h4 class="font-medium">Nhiều phương thức</h4>
                </div>
                <p class="text-sm text-gray-600">Hỗ trợ nhiều phương thức thanh toán khác nhau, đảm bảo sự tiện lợi.</p>
            </div>
        </div>

        <div class="text-gray-600 text-sm p-4 bg-white rounded-lg border border-gray-100">
            <p class="font-medium mb-2">Ghi chú về trạng thái thanh toán:</p>
            <ul class="grid md:grid-cols-3 gap-4">
                <li class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full bg-green-100 border border-green-600 mr-2"></span>
                    <span><span class="font-medium text-green-600">Hoàn Thành:</span> Thanh toán đã được xác nhận.</span>
                </li>
                <li class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full bg-yellow-100 border border-yellow-600 mr-2"></span>
                    <span><span class="font-medium text-yellow-600">Đang Xử Lý:</span> Thanh toán đang được xử lý.</span>
                </li>
                <li class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full bg-red-100 border border-red-600 mr-2"></span>
                    <span><span class="font-medium text-red-600">Thất Bại:</span> Thanh toán không thành công.</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection