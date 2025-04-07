@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h2>Chi tiết dịch vụ</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Tên dịch vụ:</strong> {{ $service->service_name }}</li>
        <li class="list-group-item"><strong>Mô tả:</strong> {{ $service->description }}</li>
        <li class="list-group-item"><strong>Giá:</strong> {{ number_format($service->price, 0, ',', '.') }} VND</li>
        <li class="list-group-item"><strong>Loại:</strong> {{ $service->service_type }}</li>
        <li class="list-group-item"><strong>Người tạo:</strong> {{ $service->employee->name ?? 'Admin' }}</li>
        
        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $service->created_at->format('d/m/Y H:i') }}</li>
        <li class="list-group-item"><strong>Ngày cập nhật:</strong> {{ $service->updated_at->format('d/m/Y H:i') }}</li>
        <a href="{{ route('admin.services.index', $service->id) }}">Trở Lại</a>
        
    </ul>
</div>
@endsection
