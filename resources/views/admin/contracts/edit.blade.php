@extends('layouts.admin')
@section('title', 'Chỉnh sửa hợp đồng')
@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-xl border border-gray-300 mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Chỉnh sửa hợp đồng</h2>
    <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Dịch vụ</label>
            <select name="service_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ $contract->service_id == $service->id ? 'selected' : '' }}>
                        {{ $service->service_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Số hợp đồng</label>
            <input type="text" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-1">Ngày bắt đầu</label>
                <input type="date" name="start_date" value="{{ old('start_date', $contract->start_date) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-1">Ngày kết thúc</label>
                <input type="date" name="end_date" value="{{ old('end_date', $contract->end_date) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-gray-700 font-bold mb-1">Tổng tiền</label>
            <input type="number" name="total_price" value="{{ old('total_price', $contract->total_price) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
        </div>

        <div class="mt-4">
            <label class="block text-gray-700 font-bold mb-1">Trạng thái</label>
            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="Chờ xử lý" {{ $contract->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="Hoạt động" {{ $contract->status == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                <option value="Hoàn thành" {{ $contract->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="Đã huỷ" {{ $contract->status == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
            </select>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Cập nhật</button>
        </div>
        
    </form>
</div>
@endsection
