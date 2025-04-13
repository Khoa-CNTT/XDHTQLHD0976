@extends('layouts.admin')

@section('title', 'Thêm khách hàng')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Thêm khách hàng</h1>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="company_name" class="block font-medium">Tên công ty</label>
            <input type="text" name="company_name" id="company_name" class="form-input w-full" placeholder="Nhập tên công ty" required>
        </div>
        <div class="mb-4">
            <label for="tax_code" class="block font-medium">Mã số thuế</label>
            <input type="text" name="tax_code" id="tax_code" class="form-input w-full" placeholder="Nhập mã số thuế" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm khách hàng</button>
    </form>
@endsection