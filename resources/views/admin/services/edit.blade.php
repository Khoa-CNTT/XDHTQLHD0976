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
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">
            ✏️ Chỉnh sửa dịch vụ
        </h1>
        
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên dịch vụ -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tên dịch vụ <span class="text-red-500">*</span></label>
                    <input type="text" name="service_name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                           value="{{ old('service_name', $service->service_name) }}">
                    @error('service_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Danh mục -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
                    <select name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-400 focus:border-purple-400">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Mô tả <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ảnh dịch vụ -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ảnh dịch vụ</label>
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="Ảnh dịch vụ" class="mb-2 h-28 rounded shadow">
                        <p class="text-xs text-gray-500 mb-1">Ảnh hiện tại</p>
                    @endif
                    <input type="file" name="image" class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-3 file:py-1 file:px-3 file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                    <p class="text-xs text-gray-500 mt-1">Để trống nếu không thay đổi ảnh</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nội dung chi tiết -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nội dung chi tiết <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="5" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">{{ old('content', $service->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Giá theo thời hạn -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-2">💰 Cấu hình giá theo thời hạn</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($durations as $duration)
                    @php
                        $price = $service->contractDurations->firstWhere('duration_id', $duration->id)->price ?? null;
                    @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $duration->label }} ({{ $duration->months }} tháng)</label>
                        <div class="relative">
                            <input type="text" name="duration_prices[{{ $duration->id }}]"
                                   value="{{ old('duration_prices.'.$duration->id, $price) }}"
                                   class="price-format w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-purple-400 focus:border-purple-400">
                            <span class="absolute right-3 top-2 text-gray-500 text-sm">VNĐ</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- HOT -->
            <div class="pt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_hot" value="1" class="form-checkbox h-5 w-5 text-red-500" {{ old('is_hot', $service->is_hot) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm font-medium text-red-600">Đánh dấu dịch vụ HOT 🔥</span>
                </label>
            </div>

            <!-- Nút -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.services.index') }}" class="px-4 py-2 text-sm bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Quay lại</a>
                <button type="submit" class="px-5 py-2 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-md transition">Cập nhật</button>
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