@extends('layouts.admin')
@section('title', 'Tạo hợp đồng mới')
@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-xl border border-gray-300 mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tạo hợp đồng mới</h2>
    <form action="{{ route('admin.contracts.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Khách hàng</label>
            <select name="customer_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Chọn khách hàng --</option>
                @foreach(\App\Models\Customer::with('user')->get() as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->user->name }} - {{ $customer->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-1">Dịch vụ</label>
            <select name="service_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Chọn dịch vụ --</option>
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

        <div class="mt-4">
            <label class="block text-gray-700 font-bold mb-1">Trạng thái</label>
            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="Chờ xử lý">Chờ xử lý</option>
                <option value="Hoàn thành">Hoàn thành</option>
                <option value="Đã huỷ">Đã huỷ</option>
            </select>
        </div>

        <div class="mt-4">
            <label class="block text-gray-700 font-bold mb-1">Điều khoản hợp đồng</label>
            <textarea name="terms" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Nhập các điều khoản hợp đồng"></textarea>
            <p class="text-sm text-gray-500 mt-1">Điều khoản mặc định sẽ được áp dụng nếu bỏ trống.</p>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
        </div>
        
    </form>
</div>

<div class="max-w-4xl mx-auto mt-8 bg-yellow-50 border border-yellow-300 p-4 rounded-lg">
    <h3 class="font-semibold text-yellow-800">Lưu ý quan trọng:</h3>
    <p class="text-yellow-700 mt-2">Tạo hợp đồng từ Admin chỉ dành cho các trường hợp đặc biệt. Thông thường, khách hàng sẽ tự ký hợp đồng trực tiếp khi sử dụng dịch vụ trên hệ thống.</p>
    <p class="text-yellow-700 mt-2">Hợp đồng tạo từ admin cần được khách hàng xác nhận và ký kết thông qua hệ thống hoặc bản cứng để đảm bảo tính pháp lý.</p>
</div>
@endsection
