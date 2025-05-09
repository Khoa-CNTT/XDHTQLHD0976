@extends('layouts.admin')
@section('title', 'Chi tiết hợp đồng')
@section('content')

<div class="max-w-4xl mx-auto mt-12 p-8 bg-white rounded-2xl shadow-xl border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Chi tiết hợp đồng</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[17px] text-gray-700 leading-relaxed">
        <div class="space-y-3">
            <div>
                <div class="text-gray-500 text-sm">Mã hợp đồng</div>
                <div class="font-medium text-gray-900">{{ $contract->contract_number }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Dịch vụ</div>
                <div class="text-gray-900">{{ $contract->service->service_name }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Trạng thái</div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                            @switch($contract->status)
                                @case('Chờ xử lý') bg-yellow-100 text-yellow-800 @break
                                @case('Hoạt động') bg-green-100 text-green-800 @break
                                @case('Hoàn thành') bg-blue-100 text-blue-800 @break
                                @case('Đã huỷ') bg-red-100 text-red-800 @break
                                @default bg-yellow-100 text-yellow-800
                            @endswitch">
                            {{ $contract->status }}
                </span>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <div class="text-gray-500 text-sm">Ngày bắt đầu</div>
                <div class="text-gray-900">{{ $contract->start_date }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Ngày kết thúc</div>
                <div class="text-gray-900">{{ $contract->end_date }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Tổng tiền</div>
                <div class="font-semibold text-gray-900">{{ number_format($contract->total_price, 0, ',', '.') }} VND</div>
            </div>
        </div>
    </div>
    <div class="mt-6 text-right">
        <a href="{{ route('admin.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
    </div>

    @if($contract->status === 'Yêu cầu huỷ')
    <form action="{{ route('admin.contracts.confirmCancel', $contract->id) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">
            Xác nhận huỷ hợp đồng
        </button>
    </form>
    @endif
</div>

@endsection
