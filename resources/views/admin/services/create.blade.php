@extends('layouts.admin')
@section('title', 'Thêm dịch vụ ')
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
<div class="container mt-4">
    <h2>Thêm dịch vụ mới</h2>
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tên dịch vụ</label>
            <input type="text" name="service_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Nội dung chi tiết</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Loại dịch vụ</label>
            <select name="service_type" class="form-control">
                <option value="Phần mềm">Phần mềm</option>
                <option value="Phần cứng">Phần cứng</option>
                <option value="Nhà mạng">Nhà mạng</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{route ('admin.services.index')}}">Trở Lại</a>
    </form>
</div>
@endsection
