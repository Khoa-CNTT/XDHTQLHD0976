@extends('layouts.admin')
@section('title', 'Tạo hợp đồng mới')
@section('content')

<div class="container mt-4">
    <h2>Tạo hợp đồng mới</h2>
    <form action="{{ route('admin.contracts.store') }}" method="POST">
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

