@extends('layouts.admin')
@section('title', 'Chi tiết dịch vụ')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Chi tiết dịch vụ</h2>
    <ul class="space-y-3 text-sm">
        <li class="list-group-item"><strong>Tên dịch vụ:</strong> {{ $service->service_name }}</li>
        <li class="list-group-item"><strong>Mô tả:</strong> {{ $service->description }}</li>
        <li class="list-group-item"><strong>Nội dung chi tiết:</strong> {{ $service->content }}</li>
        <li class="list-group-item"><strong>Giá:</strong> {{ number_format($service->price, 0, ',', '.') }} VND</li>
        <li class="list-group-item"><strong>Loại:</strong> {{ $service->service_type }}</li>
        <li class="list-group-item"><strong>Người tạo:</strong> {{ $service->employee->name ?? 'Admin' }}</li>
        
        <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $service->created_at->format('d/m/Y H:i') }}</li>
        <li class="list-group-item"><strong>Ngày cập nhật:</strong> {{ $service->updated_at->format('d/m/Y H:i') }}</li>
    </ul>
    <div class="mt-6 text-right">
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
    </div>
</div>
@endsection
