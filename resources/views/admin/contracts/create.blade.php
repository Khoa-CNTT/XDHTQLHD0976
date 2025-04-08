@extends('layouts.admin')
@section('title', 'Tạo hợp đồng mới')
@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-xl border border-gray-300 mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tạo hợp đồng mới</h2>
    <form action="{{ route('admin.contracts.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Dịch vụ</label>
            <select name="service_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Số hợp đồng</label>
            <input type="text" name="contract_number" required class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-1">Ngày bắt đầu</label>
                <input type="date" name="start_date" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-1">Ngày kết thúc</label>
                <input type="date" name="end_date" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-gray-700 font-bold mb-1">Tổng tiền</label>
            <input type="number" name="total_price" required class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
        </div>
        
    </form>
</div>
@endsection
