@extends('layouts.admin')
@section('title', 'Chỉnh sửa dịch vụ')

@if(session('success'))
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

@section('content')
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-2xl font-semibold mb-6">Chỉnh sửa dịch vụ</h2>
        
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Tên dịch vụ <span class="text-red-500">*</span></label>
                        <input type="text" name="service_name" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('service_name', $service->service_name) }}" required>
                        
                        @error('service_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Mô tả <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2" required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Danh mục <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded px-4 py-2" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Ảnh dịch vụ</label>
                        @if($service->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="max-h-40 rounded">
                                <p class="text-sm text-gray-500 mt-1">Ảnh hiện tại</p>
                            </div>
                        @endif
                        <input type="file" name="image" class="w-full border border-gray-300 rounded px-4 py-2">
                        <p class="text-sm text-gray-500 mt-1">Để trống nếu không muốn thay đổi ảnh</p>
                        @error('image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Nội dung chi tiết <span class="text-red-500">*</span></label>
                        <textarea name="content" class="w-full border border-gray-300 rounded px-4 py-2" rows="5" required>{{ old('content', $service->content) }}</textarea>
                        @error('content')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Phần cấu hình giá theo thời hạn -->
            <div class="mt-6 mb-6 border-t pt-6">
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Cấu hình giá theo thời hạn</h3>
                <p class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                    <strong>Lưu ý quan trọng:</strong> Dịch vụ chỉ sử dụng giá theo thời hạn. Để dịch vụ hoạt động đúng, vui lòng thiết lập giá cho ít nhất một thời hạn dưới đây.
                </p>
                
                <div class="flex justify-between items-center mb-4">
                    <div></div> <!-- Spacer -->
                    <a href="{{ route('admin.services.contract-durations.edit', $service->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        <i class="fas fa-cogs mr-2"></i>Quản lý giá chi tiết
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($durations as $duration)
                    <div class="p-4 border rounded-lg">
                        <label class="block mb-2 font-medium">{{ $duration->label }} ({{ $duration->months }} tháng)</label>
                        <div class="relative">
                            @php
                                $durationPrice = null;
                                foreach($service->contractDurations as $contractDuration) {
                                    if($contractDuration->duration_id == $duration->id) {
                                        $durationPrice = $contractDuration->price;
                                        break;
                                    }
                                }
                            @endphp
                            <input 
                                type="text" 
                                name="duration_prices[{{ $duration->id }}]" 
                                class="price-format w-full px-4 py-2 border border-gray-300 rounded"
                                placeholder="Nhập giá cho {{ $duration->label }}"
                                value="{{ old('duration_prices.'.$duration->id, $durationPrice) }}"
                            >
                            <div class="absolute top-1/2 transform -translate-y-1/2 right-3 text-gray-500 pointer-events-none">
                                VNĐ
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_hot" value="1" class="form-checkbox h-5 w-5" {{ old('is_hot', $service->is_hot) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700 font-medium"><span class="text-red-600 font-semibold">HOT 🔥</span></span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#3085d6',
        });
    </script>
    @endpush
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Định dạng giá tiền
        const priceInputs = document.querySelectorAll('.price-format');
        
        function formatNumberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        function formatMoney(input) {
            let value = input.value.replace(/\D/g, '');
            
            if (value) {
                input.value = formatNumberWithCommas(value);
            }
        }
        
        priceInputs.forEach(input => {
            // Khi nhập liệu
            input.addEventListener('input', function() {
                // Lưu vị trí con trỏ
                let position = this.selectionStart;
                let originalLength = this.value.length;
                
                // Loại bỏ tất cả dấu phẩy hiện tại
                let value = this.value.replace(/,/g, '');
                
                // Thêm dấu phẩy mới
                if (value) {
                    this.value = formatNumberWithCommas(value);
                }
                
                // Điều chỉnh vị trí con trỏ sau khi định dạng
                let newLength = this.value.length;
                position = position + (newLength - originalLength);
                this.setSelectionRange(position, position);
            });
            
            // Format giá trị ban đầu nếu có
            if (input.value) {
                let value = input.value.replace(/,/g, '');
                if (value) {
                    input.value = formatNumberWithCommas(value);
                }
            }
        });
        
        // Xử lý trước khi submit form
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            priceInputs.forEach(input => {
                if (input.value) {
                    // Loại bỏ tất cả dấu phẩy trước khi gửi đi
                    input.value = input.value.replace(/,/g, '');
                }
            });
        });
    });
</script>
@endsection 