@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h2>Danh sách dịch vụ</h2>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-3">Thêm dịch vụ mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên dịch vụ</th>
                <th>Mô tả</th>
                <th>Loại dịch vụ</th>
                <th>Giá</th>
                <th>Người tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->service_type }}</td>
                <td>{{ number_format($service->price, 0, ',', '.') }} VND</td>
                <td>{{ $service->employee->name ?? 'Không xác định' }}</td>
                <td>
                    <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-sm btn-info">Xem</a>
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa dịch vụ này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
