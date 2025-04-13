@extends('layouts.admin')

@section('title', 'Chỉnh sửa khách hàng')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Chỉnh sửa khách hàng</h1>
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="company_name" class="block font-medium">Tên công ty</label>
            <input type="text" name="company_name" id="company_name" class="form-input w-full" value="{{ $customer->company_name }}" required>
        </div>
        <div class="mb-4">
            <label for="tax_code" class="block font-medium">Mã số thuế</label>
            <input type="text" name="tax_code" id="tax_code" class="form-input w-full" value="{{ $customer->tax_code }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection