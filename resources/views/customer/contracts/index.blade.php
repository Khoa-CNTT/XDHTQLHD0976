@extends('layouts.customer')

@section('title', 'Danh sách hợp đồng')

@section('content')
<div class="container mt-4">
    <h2 class="text-xl font-bold mb-4">Danh sách hợp đồng</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($contracts as $contract)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $contract->service->service_name }}</h3>
                <p class="text-gray-600 mb-2"><strong>Số hợp đồng:</strong> {{ $contract->contract_number }}</p>
                <p class="text-gray-600 mb-2"><strong>Ngày bắt đầu:</strong> {{ $contract->start_date }}</p>
                <p class="text-gray-600 mb-2"><strong>Ngày kết thúc:</strong> {{ $contract->end_date }}</p>
                <p class="text-gray-600 mb-2"><strong>Trạng thái:</strong> {{ $contract->status }}</p>
                <p class="text-gray-600 mb-4"><strong>Tổng tiền:</strong> {{ number_format($contract->total_price, 0, ',', '.') }} VND</p>
                <a href="{{ route('customer.contracts.show', $contract->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Xem Chi Tiết
                </a>
            </div>
        @empty
            <p class="text-gray-600">Không có hợp đồng nào.</p>
        @endforelse
    </div>
</div>
@endsection