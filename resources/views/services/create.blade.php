@extends('layouts.dashboard')

@section('content')
<style>
    .form-container {
        width: 50%;
        margin: 50px auto;
        background: white;
        padding: 52px;
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
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-save {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }
    .btn-save:hover {
        background: #0056b3;
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
    <h2 class="form-title">Thêm Dịch Vụ Mới</h2>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Tên dịch vụ</label>
            <input type="text" id="name" name="name" placeholder="Nhập tên dịch vụ" required>
        </div>

        <div class="form-group">
            <label for="price">Giá (VNĐ)</label>
            <input type="number" id="price" name="price" placeholder="Nhập giá dịch vụ" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4" placeholder="Mô tả chi tiết dịch vụ"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Lưu Dịch Vụ</button>
            <a href="{{ route('services.index') }}" class="btn-back">⬅ Quay lại danh sách</a>
        </div>
    </form>
</div>
@endsection
