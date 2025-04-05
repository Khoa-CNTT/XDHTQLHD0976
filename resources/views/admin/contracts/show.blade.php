@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h2>Chi tiết hợp đồng</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Mã hợp đồng:</strong> {{ $contract->contract_number }}</li>
        <li class="list-group-item"><strong>Khách hàng:</strong> {{ $contract->customer->company_name }}</li>
        <li class="list-group-item"><strong>Dịch vụ:</strong> {{ $contract->service->service_name }}</li>
        <li class="list-group-item"><strong>Trạng thái:</strong> {{ $contract->status }}</li>
        <li class="list-group-item"><strong>Ngày bắt đầu:</strong> {{ $contract->start_date }}</li>
        <li class="list-group-item"><strong>Ngày kết thúc:</strong> {{ $contract->end_date }}</li>
        <li class="list-group-item"><strong>Tổng tiền:</strong> {{ $contract->total_price }}</li>
    </ul>
</div>
@endsection
