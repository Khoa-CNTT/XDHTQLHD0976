@extends('layouts.admin')
@section('title', 'Thêm dịch vụ')

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
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">

    <h2 class="text-2xl font-semibold mb-6">Thêm dịch vụ mới</h2>
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên dịch vụ</label>
            <input type="text" name="service_name" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('service_name') }}" required>
            
            @error('service_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nội dung chi tiết</label>
            <textarea name="content" class="w-full border border-gray-300 rounded px-4 py-2" rows="5" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Loại dịch vụ</label>
            <select name="service_type" class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="Phần mềm">Phần mềm</option>
                <option value="Phần cứng">Phần cứng</option>
                <option value="Nhà mạng">Nhà mạng</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-medium">Giá</label>
            <input type="text" id="price" name="price" class="w-full border border-gray-300 rounded px-4 py-2" required oninput="formatPrice(this)">
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
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
{{-- <script>
    function formatPrice(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
        } else {
            input.value = '';
        }
    }
</script> --}}
<script>
    // Format giá trị giá với dấu phẩy khi người dùng nhập
    function formatPrice(input) {
        // Lấy giá trị hiện tại và loại bỏ tất cả ký tự không phải số
        let value = input.value.replace(/\D/g, ''); // loại bỏ tất cả ký tự không phải số

        // Định dạng lại giá trị thành dạng có dấu phẩy
        if (value) {
            input.value = new Intl.NumberFormat('vi-VN').format(value);
        } else {
            input.value = '';
        }
    }

    // Trước khi gửi form, loại bỏ dấu phẩy trong giá trị để gửi một chuỗi số thuần túy
    document.querySelector('form').addEventListener('submit', function (event) {
    const priceInput = document.getElementById('price');
    priceInput.value = priceInput.value.replace(/[.,]/g, ''); // Loại bỏ dấu phẩy và chấm
});

</script>

@endsection
