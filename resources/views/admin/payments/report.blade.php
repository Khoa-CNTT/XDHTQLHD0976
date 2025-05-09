@extends('layouts.admin')

@section('title', 'Báo Cáo Thanh Toán')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Báo Cáo Thanh Toán</h1>
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại
        </a>
    </div>

    <!-- Bộ lọc báo cáo -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <form action="{{ route('admin.payments.report') }}" method="get">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" id="start_date" name="start_date" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $startDate ?? '' }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" id="end_date" name="end_date" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $endDate ?? '' }}">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select id="status" name="status" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Hoàn Thành" {{ request('status') == 'Hoàn Thành' ? 'selected' : '' }}>Hoàn Thành</option>
                        <option value="Đang Xử Lý" {{ request('status') == 'Đang Xử Lý' ? 'selected' : '' }}>Đang Xử Lý</option>
                        <option value="Thất Bại" {{ request('status') == 'Thất Bại' ? 'selected' : '' }}>Thất Bại</option>
                        <option value="Đang Đợi" {{ request('status') == 'Đang Đợi' ? 'selected' : '' }}>Đang Đợi</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <div class="flex space-x-2 w-full">
                        <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md inline-flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Tìm kiếm
                        </button>
                        <a href="{{ route('admin.payments.report') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md inline-flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Đặt lại
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tổng quan báo cáo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-500 text-white rounded-lg shadow-sm">
            <div class="p-4">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-75">Tổng doanh thu</p>
                        <p class="text-2xl font-bold mt-2">{{ number_format($totalAmount, 0, ',', '.') }} VND</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-green-500 text-white rounded-lg shadow-sm">
            <div class="p-4">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-75">Thanh toán thành công</p>
                        <p class="text-2xl font-bold mt-2">{{ $payments->where('status', 'Hoàn Thành')->count() }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-yellow-500 text-white rounded-lg shadow-sm">
            <div class="p-4">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-75">Đang xử lý</p>
                        <p class="text-2xl font-bold mt-2">{{ $payments->where('status', 'Đang Xử Lý')->count() }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-red-500 text-white rounded-lg shadow-sm">
            <div class="p-4">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-75">Thất bại</p>
                        <p class="text-2xl font-bold mt-2">{{ $payments->where('status', 'Thất Bại')->count() }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Xuất báo cáo -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
        <div class="bg-green-600 text-white px-4 py-3 rounded-t-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <span class="font-medium">Xuất Báo Cáo</span>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.payments.export') }}" method="post">
                @csrf
                <input type="hidden" name="start_date" value="{{ $startDate ?? '' }}">
                <input type="hidden" name="end_date" value="{{ $endDate ?? '' }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Xuất PDF
                </button>
            </form>
        </div>
    </div>

    <!-- Danh sách thanh toán -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="bg-gray-800 text-white px-4 py-3 rounded-t-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <span class="font-medium">Danh Sách Thanh Toán</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Mã hợp đồng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Khách hàng</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Số tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Thời gian</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Phương thức</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($payment->contract)
                            <a href="{{ route('admin.contracts.show', $payment->contract->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline">
                                {{ $payment->contract->contract_number }}
                            </a>
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($payment->contract && $payment->contract->customer)
                            {{ $payment->contract->customer->user->name }}
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                            {{ number_format($payment->amount, 0, ',', '.') }} VND
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->method }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-800' : 
                                ($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800') }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
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
                        <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500">
                            Không có dữ liệu thanh toán
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 