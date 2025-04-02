@extends('layouts.dashboard')

@push('styles')
<style>
    .service-card {
        max-width: 600px;
        margin: 40px auto;
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #ddd;
    }
    .service-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        color: #4a47a3;
        margin-bottom: 16px;
    }
    .service-info {
        font-size: 18px;
        color: #333;
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    .service-info strong {
        width: 120px;
        font-weight: bold;
        color: #555;
    }
    .service-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: bold;
        display: inline-block;
    }
    .status-active {
        background: #e0f2f1;
        color: #00796b;
    }
    .status-inactive {
        background: #ffebee;
        color: #d32f2f;
    }
    .back-btn {
        display: block;
        text-align: center;
        margin-top: 20px;
        padding: 10px 16px;
        background: #4a47a3;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #373393;
    }
</style>
@endpush

@section('content')
<div class="service-card">
    <h2 class="service-title">{{ $service->name }}</h2>

    <p class="service-info">
        <strong>💰 Giá:</strong>
        <span class="service-badge" style="background: #e3f2fd; color: #1976d2;">
            {{ number_format($service->price) }} VNĐ
        </span>
    </p>

    <p class="service-info">
        <strong>📄 Mô tả:</strong>
        <span>{{ $service->description ?? 'Không có mô tả' }}</span>
    </p>

    <p class="service-info">
        <strong>📌 Trạng thái:</strong>
        @if($service->status === 'active')
            <span class="service-badge status-active">Đang hoạt động</span>
        @else
            <span class="service-badge status-inactive">Tạm ngừng</span>
        @endif
    </p>

    <a href="{{ route('services.index') }}" class="back-btn">⬅️ Quay lại danh sách</a>
    <a href="{{ route('contracts.index') }}" class="back-btn"> ➡️Ký Hợp Đồng Ngay</a>
    
</div>
@endsection
