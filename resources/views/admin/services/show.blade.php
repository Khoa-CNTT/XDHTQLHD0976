@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h2>Chi tiết dịch vụ</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Tên dịch vụ:</strong> {{ $service->service_name }}</li>
        <li class="list-group-item"><strong>Mô tả:</strong> {{ $service->description }}</li>
        <li class="list-group-item"><strong>Loại:</strong> {{ $service->service_type }}</li>
        <li class="list-group-item"><strong>Giá:</strong> {{ number_format($service->price, 0, ',', '.') }} VND</li>
    </ul>
</div>
@endsection
