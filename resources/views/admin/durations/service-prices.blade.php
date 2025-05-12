@extends('layouts.admin')
@section('title', 'Thiết lập giá cho dịch vụ: ' . $service->service_name)

@if(session()->has('success'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endpush
@endif

@if(session()->has('error'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    </script>
    @endpush
@endif

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Thiết lập giá cho dịch vụ: {{ $service->service_name }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.services.show', $service->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-8">
        <div class="mb-4 text-gray-600">
            <p>
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Thiết lập giá dịch vụ <strong>{{ $service->service_name }}</strong> theo từng thời hạn. Để trống nếu không áp dụng thời hạn.
            </p>
        </div>

        @if($durations->count() == 0)
            <div class="text-center py-8">
                <div class="mb-4 text-red-500">
                    <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="text-lg font-medium">Chưa có thời hạn nào được thiết lập</p>
                <p class="text-gray-500 mt-2">Vui lòng tạo thời hạn trước khi thiết lập giá</p>
                <a href="{{ route('admin.services.durations.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Thêm thời hạn mới
                </a>
            </div>
        @else
            <form action="{{ route('admin.services.contract-durations.save', $service->id) }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Thời hạn</th>
                                <th class="py-3 px-6 text-center">Số tháng</th>
                                <th class="py-3 px-6 text-center">Giá dịch vụ</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($durations as $duration)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ $duration->label }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $duration->months }} tháng
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="relative">
                                            @php
                                                $price = isset($contractDurations[$duration->id]) ? $contractDurations[$duration->id]->price : null;
                                            @endphp
                                            
                                            <input 
                                                type="text" 
                                                name="durations[{{ $duration->id }}]" 
                                                value="{{ $price ? number_format($price, 0, '.', ',') : '' }}"
                                                class="price-input w-full px-4 py-2 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Nhập giá"
                                            >
                                            <div class="absolute top-1/2 transform -translate-y-1/2 right-3 text-gray-500 pointer-events-none">
                                                VNĐ
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold mb-2">Công cụ tính giá nhanh</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dựa vào thời hạn</label>
                            <select id="base_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($durations as $duration)
                                    <option value="{{ $duration->id }}">{{ $duration->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hệ số nhân</label>
                            <input type="number" id="multiplier" step="0.1" min="0.1" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Áp dụng cho thời hạn</label>
                            <select id="target_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($durations as $duration)
                                    <option value="{{ $duration->id }}">{{ $duration->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" id="calculate_price" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-calculator mr-2"></i> Tính giá
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 font-medium">
                        <i class="fas fa-save mr-2"></i> Lưu cấu hình giá
                    </button>
                </div>
            </form>
        @endif
    </div>

    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
        <h3 class="text-lg font-semibold text-blue-800 mb-2">Lưu ý khi thiết lập giá</h3>
        <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1">
            <li>Chỉ những thời hạn có giá mới được hiển thị cho khách hàng lựa chọn.</li>
            <li>Để ẩn một thời hạn, hãy để trống ô giá tương ứng.</li>
            <li>Nên thiết lập giá theo chiến lược khuyến khích khách hàng lựa chọn thời hạn dài hơn.</li>
            <li>Giá hiển thị sẽ thay thế giá mặc định của dịch vụ khi khách hàng chọn thời hạn.</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Định dạng giá tiền khi nhập
    document.addEventListener('DOMContentLoaded', function() {
        const priceInputs = document.querySelectorAll('.price-input');
        
        function formatMoney(input) {
            // Loại bỏ tất cả ký tự không phải số
            let value = input.value.replace(/\D/g, '');
            if (value) {
                // Format theo định dạng tiền Việt Nam: thêm dấu phẩy phân cách hàng nghìn
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            input.value = value;
        }
        
        priceInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Lưu vị trí con trỏ
                let position = this.selectionStart;
                let originalLength = this.value.length;
                
                // Loại bỏ tất cả dấu phẩy hiện tại
                let value = this.value.replace(/,/g, '');
                
                // Thêm dấu phẩy mới
                if (value) {
                    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                
                // Điều chỉnh vị trí con trỏ sau khi định dạng
                let newLength = this.value.length;
                position = position + (newLength - originalLength);
                this.setSelectionRange(position, position);
            });
            
            // Format initial value
            if (input.value) {
                let value = input.value.replace(/,/g, '');
                if (value) {
                    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        });
        
        // Trước khi submit form, xóa định dạng để lưu số nguyên
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const allPriceInputs = document.querySelectorAll('.price-input');
                allPriceInputs.forEach(input => {
                    if (input.value) {
                        input.value = input.value.replace(/,/g, '');
                    }
                });
            });
        }
        
        // Tính giá nhanh
        document.getElementById('calculate_price').addEventListener('click', function() {
            const baseDurationId = document.getElementById('base_duration').value;
            const targetDurationId = document.getElementById('target_duration').value;
            const multiplier = parseFloat(document.getElementById('multiplier').value);
            
            if (baseDurationId === targetDurationId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cảnh báo',
                    text: 'Thời hạn nguồn và đích không nên giống nhau'
                });
                return;
            }
            
            if (isNaN(multiplier) || multiplier <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Hệ số nhân phải lớn hơn 0'
                });
                return;
            }
            
            // Lấy giá của thời hạn gốc
            const baseInput = document.querySelector(`input[name="durations[${baseDurationId}]"]`);
            if (!baseInput.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Thời hạn nguồn chưa có giá'
                });
                return;
            }
            
            // Tính giá mới
            const basePrice = parseInt(baseInput.value.replace(/,/g, ''), 10);
            const newPrice = Math.round(basePrice * multiplier);
            
            // Đặt giá mới
            const targetInput = document.querySelector(`input[name="durations[${targetDurationId}]"]`);
            let formattedPrice = newPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            targetInput.value = formattedPrice;
            
            Swal.fire({
                icon: 'success',
                title: 'Đã tính giá',
                text: 'Giá cho thời hạn đích đã được tính. Nhấn Lưu để xác nhận.',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });
</script>
@endpush 