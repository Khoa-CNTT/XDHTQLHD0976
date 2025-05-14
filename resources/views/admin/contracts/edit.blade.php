@extends('layouts.admin')
@section('title', 'Chỉnh sửa hợp đồng')
@section('content')

<div class="max-w-4xl mx-auto my-8">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Chỉnh sửa hợp đồng #{{ $contract->contract_number }}</h2>
        </div>
        
        <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Vui lòng kiểm tra lại thông tin:</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin cơ bản -->
                <div class="space-y-6">
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Dịch vụ <span class="text-red-500">*</span></label>
                        <select id="service_id" name="service_id" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $contract->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="contract_number" class="block text-sm font-medium text-gray-700 mb-1">Số hợp đồng <span class="text-red-500">*</span></label>
                        <input type="text" id="contract_number" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
                    </div>

                    <div>
                        <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Tổng tiền <span class="text-red-500">*</span></label>
                        <div class="relative rounded-lg shadow-sm">
                            <input type="text" id="total_price" name="total_price" value="{{ old('total_price', number_format($contract->total_price, 0, ',', '.')) }}" class="w-full border border-gray-300 rounded-lg pl-3 pr-16 py-2 focus:ring-blue-500 focus:border-blue-500" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500">VND</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin thời gian và trạng thái -->
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày bắt đầu <span class="text-red-500">*</span></label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date) }}" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày kết thúc <span class="text-red-500">*</span></label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date) }}" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2" required>
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái hợp đồng <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                            <option value="Chờ xử lý" {{ $contract->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="Hoạt động" {{ $contract->status == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="Hoàn thành" {{ $contract->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="Đã huỷ" {{ $contract->status == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                        </select>
                    </div>

                  <div>
    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái thanh toán</label>
    @php
      
        $isPaid = $contract->payments()->where('status', 'Hoàn Thành')->exists();
        $autoStatus = $isPaid ? 'Đã Thanh Toán' : ($contract->payment_status ?? 'Chưa thanh toán');
    @endphp
    <select id="payment_status" name="payment_status" class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        <option value="Chưa thanh toán" {{ $autoStatus == 'Chưa thanh toán' ? 'selected' : '' }}>Chưa thanh toán</option>
        <option value="Đang Xử Lý" {{ $autoStatus == 'Đang Xử Lý' ? 'selected' : '' }}>Đang xử lý</option>
        <option value="Đã Thanh Toán" {{ $autoStatus == 'Đã Thanh Toán' ? 'selected' : '' }}>Đã thanh toán</option>
        <option value="Quá Hạn" {{ $autoStatus == 'Quá Hạn' ? 'selected' : '' }}>Quá hạn</option>
    </select>
</div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    <span class="text-red-500">*</span> Thông tin bắt buộc
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.contracts.show', $contract->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-flex items-center transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Hủy
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Format lại giá tiền khi người dùng nhập vào
document.getElementById('total_price').addEventListener('blur', function(e) {
    let value = this.value.replace(/\./g, '');
    if(value) {
        value = parseInt(value).toLocaleString('vi-VN').replace(/\./g, '.');
        this.value = value;
    }
});

// Kiểm tra ngày kết thúc phải sau ngày bắt đầu
document.querySelector('form').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
    
    if(endDate < startDate) {
        e.preventDefault();
        alert('Ngày kết thúc phải sau ngày bắt đầu');
    }
});
</script>
@endsection
