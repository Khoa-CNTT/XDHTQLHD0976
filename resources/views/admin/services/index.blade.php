@extends('layouts.admin')
<style>
    .table td.text-truncate {
    white-space: nowrap; /* Không xuống dòng */
    overflow: hidden; /* Ẩn nội dung tràn */
    text-overflow: ellipsis; /* Thêm dấu "..." nếu nội dung quá dài */
    max-width: 300px; /* Đặt chiều rộng tối đa */
}   
    
        .table th, .table td {
            text-align: center
;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-info, .btn-warning, .btn-danger {
            margin: 0 2px;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        
</style>
@section('content')

<div class="container mt-4">
    <h2>Danh sách dịch vụ</h2>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-3">Thêm dịch vụ mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 20%;">Tên dịch vụ</th>
                <th style="width: 35%;">Mô tả</th>
                <th style="width: 10%;">Giá</th>
                <th style="width: 15%;">Loại dịch vụ</th>
                <th style="width: 10%;">Người tạo</th>
                <th style="width: 10%;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td class="text-truncate" style="max-width: 300px;">{{ $service->description }}</td>
                <td>{{ number_format($service->price, 0, ',', '.') }} VND</td>
                <td>{{ $service->service_type }}</td>
                <td>{{ $service->employee->name ?? 'Admin' }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-sm btn-info mb-1">Xem</a>
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning mb-1">Sửa</a>
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