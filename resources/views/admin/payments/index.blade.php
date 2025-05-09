@extends('layouts.admin')

@section('title', 'Quản Lý Thanh Toán')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản Lý Thanh Toán</h1>
        <a href="{{ route('admin.payments.report') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Xem Báo Cáo
        </a>
    </div>

    <!-- Bộ lọc -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <form action="{{ route('admin.payments.index') }}" method="get">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" id="start_date" name="start_date" class="pl-10 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ request('start_date') }}">
                    </div>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" id="end_date" name="end_date" class="pl-10 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select id="status" name="status" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="Hoàn Thành" {{ request('status') == 'Hoàn Thành' ? 'selected' : '' }}>Hoàn Thành</option>
                        <option value="Đang Xử Lý" {{ request('status') == 'Đang Xử Lý' ? 'selected' : '' }}>Đang Xử Lý</option>
                        <option value="Thất Bại" {{ request('status') == 'Thất Bại' ? 'selected' : '' }}>Thất Bại</option>
                        <option value="Đang Đợi" {{ request('status') == 'Đang Đợi' ? 'selected' : '' }}>Đang Đợi</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <div class="flex space-x-2 w-full">
                        <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Lọc
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-center px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Đặt lại
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bảng dữ liệu -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Mã hợp đồng</th>
                    <th class="py-3 px-4 text-left">Khách hàng</th>
                    <th class="py-3 px-4 text-right">Số tiền</th>
                    <th class="py-3 px-4 text-left">Thời gian</th>
                    <th class="py-3 px-4 text-left">Phương thức</th>
                    <th class="py-3 px-4 text-left">Trạng thái</th>
                    <th class="py-3 px-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($payments as $payment)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $payment->id }}</td>
                    <td class="py-3 px-4">
                        @if ($payment->contract)
                        <a href="{{ route('admin.contracts.show', $payment->contract->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ $payment->contract->contract_number }}
                        </a>
                        @else
                        <span class="text-gray-500">N/A</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if ($payment->contract && $payment->contract->customer)
                        {{ $payment->contract->customer->user->name }}
                        @else
                        <span class="text-gray-500">N/A</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-right font-medium">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}</td>
                    <td class="py-3 px-4">{{ $payment->method }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-800' : 
                            ($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi' ? 'bg-yellow-100 text-yellow-800' : 
                            'bg-red-100 text-red-800') }}">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-blue-600 hover:text-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-6 px-4 text-center text-gray-500">Không có dữ liệu thanh toán</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
@endsection 