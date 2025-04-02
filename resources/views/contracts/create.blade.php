@extends('layouts.dashboard')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 20px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
        margin-bottom: 5px;
    }
    .form-input {
        width: 100%;
        padding: 10px;
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
    <h2 class="form-title">Tạo Hợp Đồng</h2>

    <form action="{{ route('contracts.store') }}" method="POST">
        @csrf

        <!-- Chọn Khách Hàng -->
        <div class="form-group">
            <label class="form-label">Khách hàng</label>
            <select name="customer_id" class="form-input">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Chọn Dịch Vụ -->
        <div class="form-group">
            <label class="form-label">Dịch vụ</label>
            <select name="service_id" class="form-input" id="serviceSelect">
                <option value="">-- Chọn Dịch Vụ --</option>
                @foreach($services as $srv)
                    <option value="{{ $srv->id }}" data-price="{{ $srv->price }}"
                        {{ $service && $service->id == $srv->id ? 'selected' : '' }}>
                        {{ $srv->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Ngày Bắt Đầu -->
        <div class="form-group">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-input">
        </div>

        <!-- Số Tiền -->
        <div class="form-group">
            <label class="form-label">Số tiền</label>
            <input type="number" name="amount" id="amountInput" class="form-input" 
                value="{{ $service ? $service->price : '' }}">
        </div>

        <!-- Nút Xác Nhận -->
        <div class="mt-6">
            <button type="submit" class="btn-submit">✅ Xác nhận hợp đồng</button>
            <a href="{{ route('contracts.index') }}" class="btn-cancel">Hủy</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('serviceSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let price = selectedOption.getAttribute('data-price');
        document.getElementById('amountInput').value = price ? price : '';
    });
</script>

@endsection
