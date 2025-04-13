@extends('layouts.admin')

@section('title', 'Thêm nhân viên')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
    <h2 class="text-2xl font-semibold mb-6">Thêm nhân viên</h2>

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="user_id" class="block mb-1 font-medium">ID Người dùng</label>
            <input type="number" name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Nhập ID người dùng" required>
        </div>

        <div class="mb-4">
            <label for="position" class="block mb-1 font-medium">Chức vụ</label>
            <input type="text" name="position" id="position" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Nhập chức vụ" required>
        </div>

        <div class="mb-4">
            <label for="department" class="block mb-1 font-medium">Phòng ban</label>
            <input type="text" name="department" id="department" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Nhập phòng ban" required>
        </div>

        <div class="mb-4">
            <label for="salary" class="block mb-1 font-medium">Lương</label>
            <input type="text" name="salary" id="salary" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Nhập lương" required oninput="formatSalary(this)">
        </div>

        <div class="mb-6">
            <label for="hired_date" class="block mb-1 font-medium">Ngày vào làm</label>
            <input type="date" name="hired_date" id="hired_date" class="w-full border border-gray-300 rounded px-4 py-2" required>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Thêm nhân viên</button>
        </div>
    </form>
</div>

<script>
    function formatSalary(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = value ? new Intl.NumberFormat('vi-VN').format(value) : '';
    }

    document.querySelector('form').addEventListener('submit', function (event) {
        const salaryInput = document.getElementById('salary');
        salaryInput.value = salaryInput.value.replace(/[.,]/g, '');
    });
</script>
@endsection
