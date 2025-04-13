<!-- filepath: c:\Users\ASUS_TUF\Documents\QuanLyHopDong\ConT_management\resources\views\admin\employees\create.blade.php -->
@extends('layouts.admin')

@section('title', 'Thêm nhân viên')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Thêm nhân viên</h1>
    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="user_id" class="block font-medium">ID Người dùng</label>
            <input type="number" name="user_id" id="user_id" class="form-input w-full" placeholder="Nhập ID người dùng" required>
        </div>
        <div class="mb-4">
            <label for="position" class="block font-medium">Chức vụ</label>
            <input type="text" name="position" id="position" class="form-input w-full" placeholder="Nhập chức vụ" required>
        </div>
        <div class="mb-4">
            <label for="department" class="block font-medium">Phòng ban</label>
            <input type="text" name="department" id="department" class="form-input w-full" placeholder="Nhập phòng ban" required>
        </div>
        <div class="mb-4">
            <label for="salary" class="block font-medium">Lương</label>
            <input type="number" name="salary" id="salary" class="form-input w-full" placeholder="Nhập lương" required>
        </div>
        <div class="mb-4">
            <label for="hired_date" class="block font-medium">Ngày vào làm</label>
            <input type="date" name="hired_date" id="hired_date" class="form-input w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
    </form>
@endsection