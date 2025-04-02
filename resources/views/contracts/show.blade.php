@extends('layouts.dashboard')

@section('content')
<style>
    .contract-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .contract-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }
    .contract-info p {
        font-size: 16px;
        margin: 8px 0;
        color: #555;
    }
    .status-active {
        background: green;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .status-inactive {
        background: red;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .btn {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        font-size: 14px;
        text-align: center;
    }
    .btn-back {
        background: gray;
    }
    .btn-edit {
        background: blue;
    }
</style>

<div class="contract-container">
    <h2 class="contract-title">Thông Tin Hợp Đồng</h2>
    
    <div class="contract-info">
        <p><strong>Số hợp đồng:</strong> {{ $contract->contract_number }}</p>
        <p><strong>Tiêu đề:</strong> {{ $contract->title }}</p>
        <p><strong>Ngày bắt đầu:</strong> {{ $contract->start_date }}</p>
        <p><strong>Số tiền:</strong> {{ number_format($contract->amount, 0, ',', '.') }} VND</p>
        <p><strong>Khách hàng:</strong> {{ $contract->customer->name }}</p>
        <p><strong>Trạng thái:</strong> 
            <span class="{{ $contract->status == 'active' ? 'status-active' : 'status-inactive' }}">
                {{ ucfirst($contract->status) }}
            </span>
        </p>
    </div>

    <div class="mt-6">
        <a href="{{ route('contracts.index') }}" class="btn btn-back">Quay Lại</a>
        @can('update', $contract)
            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-edit">Chỉnh Sửa</a>
        @endcan
    </div>
</div>
@endsection
