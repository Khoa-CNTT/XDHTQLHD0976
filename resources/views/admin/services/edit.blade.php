@extends('layouts.admin')
@section('title', 'Chỉnh sửa dịch vụ')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">

    <h2 class="text-2xl font-semibold mb-6">Chỉnh sửa dịch vụ</h2>
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên dịch vụ</label>
            <input type="text" name="service_name" value="{{ old('service_name', $service->service_name) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2" required>
            @error('service_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2" required>{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nội dung chi tiết</label>
            <textarea name="content" class="w-full border border-gray-300 rounded px-4 py-2" rows="5" required>{{ old('content', $service->content) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Ảnh dịch vụ</label>
            @if ($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="Ảnh dịch vụ" class="w-32 h-32 object-cover mb-2">
            @endif
            <input type="file" name="image" class="w-full border border-gray-300 rounded px-4 py-2">
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Danh mục</label>
            <select name="category_id" class="w-full border border-gray-300 rounded px-4 py-2" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-medium">Giá</label>
            <input type="text" id="price" name="price"
            value="{{ number_format(old('price', $service->price), 0, ',', '.') }}"
                   class="w-full border border-gray-300 rounded px-4 py-2" required oninput="formatPrice(this)">
        </div>
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input
                    type="checkbox"
                    name="is_hot"
                    value="1"
                    class="form-checkbox text-red-600 h-5 w-5"
                    {{ old('is_hot', $service->is_hot) == 1 ? 'checked' : '' }}

                >
                <span class="ml-2 text-gray-700 font-medium">
                   <span class="text-red-600 font-semibold">HOT 🔥</span>
                </span>
            </label>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Cập nhật</button>
        </div>
    </form>
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

@push('scripts')
<script>
    // Format lại giá có dấu chấm ngăn cách hàng nghìn
    function formatPrice(input) {
        let value = input.value.replace(/\D/g, ''); // bỏ hết ký tự không phải số
        if (value) {
            input.value = new Intl.NumberFormat('vi-VN').format(value);
        } else {
            input.value = '';
        }
    }

    // Trước khi gửi, loại bỏ dấu chấm để giá là số thuần
    document.getElementById('editServiceForm').addEventListener('submit', function () {
        const priceInput = document.getElementById('price');
        priceInput.value = priceInput.value.replace(/\./g, ''); // xóa dấu chấm
    });
</script>
@endpush