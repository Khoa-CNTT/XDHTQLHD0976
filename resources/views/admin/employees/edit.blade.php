@extends('layouts.admin')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
        <h2 class="text-2xl font-semibold mb-6">Chỉnh sửa nhân viên</h2>
        <form id="editEmployeeForm" action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="position" class="block mb-1 font-medium">Chức vụ</label>
                <input type="text" name="position" id="position" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('position', $employee->position) }}" required>
            </div>

            <div class="mb-4">
                <label for="department" class="block mb-1 font-medium">Phòng ban</label>
                <input type="text" name="department" id="department" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('department', $employee->department) }}" required>
            </div>

            <div class="mb-4">
                <label for="salary" class="block mb-1 font-medium">Lương</label>
                <input type="text" name="salary" id="salary" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ number_format(old('salary', $employee->salary), 0, ',', '.') }}" required oninput="formatSalary(this)">
            </div>

            <div class="mb-4">
                <label for="hired_date" class="block mb-1 font-medium">Ngày vào làm</label>
                <input type="date" name="hired_date" id="hired_date" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('hired_date', $employee->hired_date) }}" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Định dạng lương có dấu chấm ngăn cách hàng nghìn
    function formatSalary(input) {
        let value = input.value.replace(/\D/g, ''); // bỏ hết ký tự không phải số
        if (value) {
            input.value = new Intl.NumberFormat('vi-VN').format(value);
        } else {
            input.value = '';
        }
    }

    // Trước khi gửi, loại bỏ dấu chấm để lương là số thuần
    document.getElementById('editEmployeeForm').addEventListener('submit', function () {
        const salaryInput = document.getElementById('salary');
        salaryInput.value = salaryInput.value.replace(/\./g, ''); // xóa dấu chấm
    });
</script>
@endpush
