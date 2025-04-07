@extends('layouts.customer')
@section('title', 'Ký hợp đồng')
@section('content')




<form action="{{ route('customer.contracts.sign', $contract->id) }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="customer_name">Tên khách hàng</label>
        <input type="text" name="customer_name" id="customer_name" class="form-control" required>
    </div>
    <div class="mb-4">
        <label for="customer_email">Email</label>
        <input type="email" name="customer_email" id="customer_email" class="form-control" required>
    </div>
    <div class="mb-4">
        <label for="signature_data">Chữ ký</label>
        <textarea name="signature_data" id="signature_data" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Ký hợp đồng</button>
</form>

@endsection