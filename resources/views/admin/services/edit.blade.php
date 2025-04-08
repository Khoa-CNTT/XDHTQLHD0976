@extends('layouts.admin')
@section('title', 'Chỉnh sửa dịch vụ')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">

    <h2 class="text-2xl font-semibold mb-6">Chỉnh sửa dịch vụ</h2>
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên dịch vụ</label>
            <input type="text" name="service_name" value="{{ old('service_name', $service->service_name) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-4 py-2">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nội dung chi tiết</label>
            <textarea name="content" class="w-full border border-gray-300 rounded px-4 py-2" rows="5">{{ old('content', $service->content) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Loại dịch vụ</label>
            <select name="service_type" class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="Phần mềm" {{ $service->service_type == 'Phần mềm' ? 'selected' : '' }}>Phần mềm</option>
                <option value="Phần cứng" {{ $service->service_type == 'Phần cứng' ? 'selected' : '' }}>Phần cứng</option>
                <option value="Nhà mạng" {{ $service->service_type == 'Nhà mạng' ? 'selected' : '' }}>Nhà mạng</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-medium">Giá</label>
            <input type="number" name="price" value="{{ old('price', $service->price) }}"
                   class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
