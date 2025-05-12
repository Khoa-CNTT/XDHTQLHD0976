@extends('layouts.admin')
@section('title', 'Thiết lập giá dịch vụ theo thời hạn')

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
        <h2 class="text-2xl font-semibold">Thiết lập giá dịch vụ theo thời hạn</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.durations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-8">
        <div class="mb-4 text-gray-600">
            <p>
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Thiết lập giá cho từng dịch vụ theo các thời hạn khác nhau. Để trống nếu không áp dụng thời hạn cho dịch vụ.
            </p>
        </div>

        @if($services->count() == 0 || $durations->count() == 0)
            <div class="text-center py-8">
                <div class="mb-4 text-red-500">
                    <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                @if($durations->count() == 0)
                    <p class="text-lg font-medium">Chưa có thời hạn nào được thiết lập</p>
                    <p class="text-gray-500 mt-2">Vui lòng tạo thời hạn trước khi thiết lập giá</p>
                    <a href="{{ route('admin.durations.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Thêm thời hạn mới
                    </a>
                @elseif($services->count() == 0)
                    <p class="text-lg font-medium">Chưa có dịch vụ nào được thiết lập</p>
                    <p class="text-gray-500 mt-2">Vui lòng tạo dịch vụ trước khi thiết lập giá</p>
                    <a href="{{ route('admin.services.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Thêm dịch vụ mới
                    </a>
                @endif
            </div>
        @else
            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Công cụ tính giá nhanh</h3>
                <form action="{{ route('admin.services.contract-durations.apply-formula') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dựa vào thời hạn</label>
                        <select name="source_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($durations as $duration)
                                <option value="{{ $duration->id }}">{{ $duration->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hệ số nhân</label>
                        <input type="number" name="multiplier" step="0.1" min="0.1" value="2.0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Áp dụng cho thời hạn</label>
                        <select name="target_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($durations as $duration)
                                <option value="{{ $duration->id }}">{{ $duration->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Áp dụng cho</label>
                        <div class="flex items-center h-10 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="apply_to" value="all" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                <span class="ml-2 text-gray-700">Tất cả dịch vụ</span>
                            </label>
                            <label class="inline-flex items-center ml-4">
                                <input type="radio" name="apply_to" value="selected" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-gray-700">Dịch vụ đã chọn</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-calculator mr-2"></i> Áp dụng công thức
                        </button>
                    </div>
                </form>
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="show_all_services" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="show_all_services" class="ml-2 text-sm font-medium text-gray-700">Hiện tất cả dịch vụ (kể cả chưa có giá)</label>
                </div>
            </div>

            <form action="{{ route('admin.durations.save-price') }}" method="POST" id="price-form">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left sticky left-0 bg-gray-200 z-10">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="select_all" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-2">Dịch vụ</span>
                                    </div>
                                </th>
                                @foreach($durations as $duration)
                                    <th class="py-3 px-6 text-center">{{ $duration->label }} ({{ $duration->months }} tháng)</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light" id="services-table-body">
                            @foreach($services as $service)
                                @php
                                    $hasAnyPrice = isset($contractDurations[$service->id]) && count($contractDurations[$service->id]) > 0;
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-100 service-row {{ $hasAnyPrice ? '' : 'no-price' }}" data-id="{{ $service->id }}">
                                    <td class="py-3 px-6 text-left sticky left-0 bg-white z-10">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="service-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <div class="ml-2">
                                                <span class="font-medium">{{ $service->service_name }}</span>
                                                @if($service->is_hot)
                                                    <span class="ml-2 bg-orange-100 text-orange-800 text-xs px-2 py-0.5 rounded">HOT</span>
                                                @endif
                                                <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($service->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($durations as $duration)
                                        <td class="py-3 px-6 text-center">
                                            @php
                                                $price = null;
                                                if(isset($contractDurations[$service->id])) {
                                                    $contractDuration = $contractDurations[$service->id]->firstWhere('duration_id', $duration->id);
                                                    if($contractDuration) {
                                                        $price = $contractDuration->price;
                                                    }
                                                }
                                            @endphp
                                            
                                            <div class="relative">
                                                <input 
                                                    type="text" 
                                                    name="prices[{{ $service->id }}][{{ $duration->id }}]" 
                                                    value="{{ $price ? number_format($price, 0, '.', ',') : '' }}"
                                                    class="price-input w-full px-4 py-2 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Nhập giá"
                                                >
                                                <div class="absolute top-1/2 transform -translate-y-1/2 right-3 text-gray-500 pointer-events-none">
                                                    VNĐ
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        <h3 class="text-lg font-semibold text-blue-800 mb-2">Hướng dẫn thiết lập giá</h3>
        <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1">
            <li>Giá được áp dụng cho từng dịch vụ và thời hạn cụ thể.</li>
            <li>Để trống ô giá nếu không áp dụng thời hạn đó cho dịch vụ.</li>
            <li>Chỉ nhập số, không cần nhập dấu chấm hoặc phẩy (định dạng sẽ tự động).</li>
            <li>Sử dụng công cụ tính giá nhanh để áp dụng công thức tính giá cho nhiều dịch vụ cùng lúc.</li>
            <li>Ví dụ: Dùng thời hạn 6 tháng làm cơ sở, nhân với 1.8 để ra giá cho thời hạn 12 tháng.</li>
            <li>Thay đổi giá sẽ không ảnh hưởng đến các hợp đồng đã ký kết.</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Định dạng giá tiền khi nhập
    document.addEventListener('DOMContentLoaded', function() {
        const priceInputs = document.querySelectorAll('.price-input');
        const showAllServicesCheckbox = document.getElementById('show_all_services');
        const serviceRows = document.querySelectorAll('.service-row');
        const selectAllCheckbox = document.getElementById('select_all');
        const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
        
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
        
        // Hiển thị/ẩn dịch vụ chưa có giá
        function toggleNoPriceServices() {
            const showAll = showAllServicesCheckbox.checked;
            serviceRows.forEach(row => {
                if (row.classList.contains('no-price')) {
                    row.style.display = showAll ? 'table-row' : 'none';
                }
            });
        }
        
        // Mặc định ẩn dịch vụ chưa có giá
        toggleNoPriceServices();
        
        showAllServicesCheckbox.addEventListener('change', toggleNoPriceServices);
        
        // Chọn tất cả dịch vụ
        selectAllCheckbox.addEventListener('change', function() {
            const checked = this.checked;
            serviceCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('.service-row');
                // Chỉ chọn các dịch vụ đang hiển thị
                if (row.style.display !== 'none') {
                    checkbox.checked = checked;
                }
            });
        });

        // Trước khi submit form, xóa định dạng để lưu số nguyên
        const form = document.getElementById('price-form');
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
    });
</script>
@endpush 