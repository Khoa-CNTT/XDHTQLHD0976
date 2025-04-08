@extends('layouts.admin')
@section('title', 'Chi tiết hợp đồng')
@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Chi tiết hợp đồng</h2>
    <ul class="space-y-3">
        <li class="list-group-item"><strong>Mã hợp đồng:</strong> {{ $contract->contract_number }}</li>
        <li class="list-group-item"><strong>Dịch vụ:</strong> {{ $contract->service->service_name }}</li>
        <li class="list-group-item"><strong>Trạng thái:</strong> {{ $contract->status }}</li>
        <li class="list-group-item"><strong>Ngày bắt đầu:</strong> {{ $contract->start_date }}</li>
        <li class="list-group-item"><strong>Ngày kết thúc:</strong> {{ $contract->end_date }}</li>
        <li class="list-group-item"><strong>Tổng tiền:</strong> {{ $contract->total_price }}</li>

    </ul>
</div>
@endsection
