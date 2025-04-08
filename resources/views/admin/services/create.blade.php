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
            <input type="text" name="service_name" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2"></textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nội dung chi tiết</label>
            <textarea name="content" class="w-full border border-gray-300 rounded px-4 py-2" rows="5">{{ old('content') }}</textarea>
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
            <input type="number" name="price" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
        </div>
    </form>
</div>
@endsection
