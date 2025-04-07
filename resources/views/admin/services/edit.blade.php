@extends('layouts.admin')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
</script>
@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa dịch vụ</h2>
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Tên dịch vụ</label>
            <input type="text" name="service_name" class="form-control" value="{{ old('service_name', $service->service_name) }}" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Loại dịch vụ</label>
            <select name="service_type" class="form-control">
                <option value="Phần mềm" {{ $service->service_type == 'Phần mềm' ? 'selected' : '' }}>Phần mềm</option>
                <option value="Phần cứng" {{ $service->service_type == 'Phần cứng' ? 'selected' : '' }}>Phần cứng</option>
                <option value="Nhà mạng" {{ $service->service_type == 'Nhà mạng' ? 'selected' : '' }}>Nhà mạng</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection
