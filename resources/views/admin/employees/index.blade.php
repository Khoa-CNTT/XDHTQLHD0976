@extends('layouts.admin')

@section('title', 'Quản lý nhân viên')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Danh sách nhân viên</h1>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-4">Thêm nhân viên</a>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Người dùng</th>
                <th class="px-4 py-2">Chức vụ</th>
                <th class="px-4 py-2">Phòng ban</th>
                <th class="px-4 py-2">Lương</th>
                <th class="px-4 py-2">Ngày vào làm</th>
                <th class="px-4 py-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as  $index =>   $employee)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $employee->user->name }}</td>
                    <td class="border px-4 py-2">{{ $employee->position }}</td>
                    <td class="border px-4 py-2">{{ $employee->department }}</td>
                    <td class="border px-4 py-2">{{ number_format($employee->salary, 0, ',', '.') }} VND</td>
                    <td class="border px-4 py-2">{{ $employee->hired_date }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection