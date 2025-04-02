@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .form-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: bold;
        color: #555;
        display: block;
    }
    .form-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    .btn-submit {
        background: green;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        display: inline-block;
        text-align: center;
    }
    .btn-cancel {
        background: gray;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        display: inline-block;
        text-align: center;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Chỉnh Sửa Hợp Đồng</h2>

    <form action="{{ route('contracts.update', $contract) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Số hợp đồng</label>
            <input type="text" name="contract_number" value="{{ $contract->contract_number }}" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="title" value="{{ $contract->title }}" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" value="{{ $contract->start_date }}" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">Số tiền</label>
            <input type="number" name="amount" value="{{ $contract->amount }}" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-input">
                <option value="active" {{ $contract->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $contract->status == 'inactive' ? 'selected' : '' }}>Tạm ngừng</option>
            </select>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-submit">Cập Nhật</button>
            <a href="{{ route('contracts.index') }}" class="btn-cancel">Hủy</a>
        </div>
    </form>
</div>
@endsection
