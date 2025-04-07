@extends('layouts.admin')
@section('content')
<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: #000000;
        font-family: 'Arial', sans-serif;
    }
    .container {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1s ease-in-out;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        text-transform: uppercase;
    }
    label {
        font-weight: bold;
        color: #000;
    }
    .form-control {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #000;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        color: #000;
    }
    .btn-success {
        background: #28a745;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background: #218838;
        transform: scale(1.05);
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<div class="container mt-4">
    <h2>Tạo hợp đồng mới</h2>
    <form action="{{ route('admin.contracts.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Dịch vụ</label>
            <select name="service_id" class="form-control">
                @foreach($services as $service)
                <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Số hợp đồng</label>
            <input type="text" name="contract_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tổng tiền</label>
            <input type="number" name="total_price" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection