@extends('layouts.admin')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Chỉnh sửa nhân viên</h1>
    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="position" class="block font-medium">Chức vụ</label>
            <input type="text" name="position" id="position" class="form-input w-full" value="{{ $employee->position }}" required>
        </div>
        <div class="mb-4">
            <label for="department" class="block font-medium">Phòng ban</label>
            <input type="text" name="department" id="department" class="form-input w-full" value="{{ $employee->department }}" required>
        </div>
        <div class="mb-4">
            <label for="salary" class="block font-medium">Lương</label>
            <input type="number" name="salary" id="salary" class="form-input w-full" value="{{ $employee->salary }}" required>
        </div>
        <div class="mb-4">
            <label for="hired_date" class="block font-medium">Ngày vào làm</label>
            <input type="date" name="hired_date" id="hired_date" class="form-input w-full" value="{{ $employee->hired_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection