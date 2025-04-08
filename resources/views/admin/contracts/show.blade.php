@extends('layouts.admin')
@section('title', 'Chi tiết hợp đồng')
@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-xl border border-gray-300 mt-6">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Chi tiết hợp đồng</h2>
    <ul class="space-y-3">
        <li class="list-group-item"><strong>Mã hợp đồng:</strong> {{ $contract->contract_number }}</li>
        <li class="list-group-item"><strong>Dịch vụ:</strong> {{ $contract->service->service_name }}</li>
        <li class="list-group-item"><strong>Trạng thái:</strong> {{ $contract->status }}</li>
        <li class="list-group-item"><strong>Ngày bắt đầu:</strong> {{ $contract->start_date }}</li>
        <li class="list-group-item"><strong>Ngày kết thúc:</strong> {{ $contract->end_date }}</li>
        <li class="list-group-item"><strong>Tổng tiền:</strong> {{ $contract->total_price }}</li>

    </ul>
    <div class="mt-6 text-right">
        <a href="{{ route('admin.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
    </div>
</div>

@endsection
