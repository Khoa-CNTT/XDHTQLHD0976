@extends('layouts.dashboard')

@section('content')
<style>
    .form-container {
        width: 50%;
        margin: 50px auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .form-title {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #444;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #f59e0b;
        outline: none;
        box-shadow: 0 0 5px rgba(245, 158, 11, 0.5);
    }
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-update {
        background: #f59e0b;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }
    .btn-update:hover {
        background: #d97706;
    }
    .btn-back {
        text-decoration: none;
        color: #555;
        font-size: 16px;
    }
    .btn-back:hover {
        text-decoration: underline;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Chỉnh Sửa Dịch Vụ</h2>

    <form action="{{ route('services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên dịch vụ</label>
            <input type="text" id="name" name="name" value="{{ $service->name }}" required>
        </div>

        <div class="form-group">
            <label for="price">Giá (VNĐ)</label>
            <input type="number" id="price" name="price" value="{{ $service->price }}" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4">{{ $service->description }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update">Cập nhật</button>
            <a href="{{ route('services.index') }}" class="btn-back">⬅ Quay lại danh sách</a>
        </div>
    </form>
</div>
@endsection
