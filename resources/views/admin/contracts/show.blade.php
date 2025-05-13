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

<div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Chữ ký hợp đồng</h3>
        <div class="flex space-x-2">
            @if($contract->signatures->isNotEmpty() && $contract->signatures->first()->isFullySigned())
            <a href="{{ route('admin.contracts.pdf', $contract->id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Xuất PDF
            </a>
            @endif
        </div>
    </div>
    
    <div class="p-6">
        @if($contract->signatures->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p>Khách hàng chưa ký hợp đồng này.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border rounded-lg p-4 bg-gray-50">
                <h4 class="text-md font-semibold text-gray-700 mb-3">Chữ ký khách hàng (Bên B)</h4>
                <div class="mb-3">
                    <p class="mb-1"><strong>Người ký:</strong> {{ $contract->signatures->first()->customer_name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $contract->signatures->first()->customer_email }}</p>
                    <p class="mb-1"><strong>CMND/CCCD:</strong> {{ $contract->signatures->first()->identity_card }}</p>
                    <p><strong>Ngày ký:</strong> {{ date('d/m/Y H:i', strtotime($contract->signatures->first()->signed_at)) }}</p>
                </div>
                <div class="border p-3 rounded bg-white">
                    <img src="{{ $contract->signatures->first()->signature_data }}" alt="Chữ ký khách hàng" class="max-h-24">
                </div>
            </div>
            
            <div class="border rounded-lg p-4 bg-gray-50">
                <h4 class="text-md font-semibold text-gray-700 mb-3">Chữ ký admin (Bên A)</h4>
                @if($contract->signatures->first()->admin_signature_data)
                <div class="mb-3">
                    <p class="mb-1"><strong>Người ký:</strong> {{ $contract->signatures->first()->admin_name }}</p>
                    <p class="mb-1"><strong>Chức vụ:</strong> {{ $contract->signatures->first()->admin_position }}</p>
                    <p><strong>Ngày ký:</strong> {{ date('d/m/Y H:i', strtotime($contract->signatures->first()->admin_signed_at)) }}</p>
                </div>
                <div class="border p-3 rounded bg-white">
                    <img src="{{ $contract->signatures->first()->admin_signature_data }}" alt="Chữ ký admin" class="max-h-24">
                </div>
                <div class="mt-2 text-xs text-gray-500 italic">
                    <p>Chữ ký được áp dụng tự động sau khi khách hàng ký và thanh toán</p>
                </div>
                @else
                <div class="text-center py-4 text-gray-500">
                    <p>Chữ ký bên A sẽ được tự động thêm sau khi khách hàng thanh toán.</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
