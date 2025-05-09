@extends('layouts.customer')

@section('title', 'Lịch sử thanh toán')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
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
                    <td colspan="6" class="p-3 text-center text-gray-500">Không có dữ liệu thanh toán.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection