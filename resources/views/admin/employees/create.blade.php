@extends('layouts.admin')

@section('title', 'Thêm nhân viên')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl border border-gray-300">
    <h2 class="text-2xl font-semibold mb-6">Thêm nhân viên mới</h2>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        <div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-100">
            <h3 class="text-lg font-medium text-blue-800 mb-4">Thông tin tài khoản</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="name" class="block mb-1 font-medium">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-4 py-2 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                    <div class="mb-4">
                        <label for="email" class="block mb-1 font-medium">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-4 py-2 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            
                
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="identity_card" class="block mb-1 font-medium">Căn cước công dân <span class="text-red-500">*</span></label>
                    <input type="text" name="identity_card" id="identity_card" class="w-full border border-gray-300 rounded px-4 py-2 @error('identity_card') border-red-500 @enderror" value="{{ old('identity_card') }}" required maxlength="12">
                    @error('identity_card')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Căn cước công dân gồm 12 chữ số</p>
                </div>

                <div class="mb-4">
                    <label for="dob" class="block mb-1 font-medium">Ngày sinh <span class="text-red-500">*</span></label>
                    <input type="date" name="dob" id="dob" class="w-full border border-gray-300 rounded px-4 py-2 @error('dob') border-red-500 @enderror" value="{{ old('dob') }}" required>
                    @error('dob')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="password" class="block mb-1 font-medium">Mật khẩu <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-4 py-2 @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Mật khẩu phải có ít nhất 8 ký tự</p>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block mb-1 font-medium">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded px-4 py-2 @error('phone') border-red-500 @enderror" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="address" class="block mb-1 font-medium">Địa chỉ</label>
                <input type="text" name="address" id="address" class="w-full border border-gray-300 rounded px-4 py-2 @error('address') border-red-500 @enderror" value="{{ old('address') }}">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-green-50 p-4 rounded-lg mb-6 border border-green-100">
            <h3 class="text-lg font-medium text-green-800 mb-4">Thông tin công việc</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="position" class="block mb-1 font-medium">Chức vụ <span class="text-red-500">*</span></label>
                    <input type="text" name="position" id="position" class="w-full border border-gray-300 rounded px-4 py-2 @error('position') border-red-500 @enderror" value="{{ old('position') }}" required>
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="department" class="block mb-1 font-medium">Phòng ban <span class="text-red-500">*</span></label>
                    <input type="text" name="department" id="department" class="w-full border border-gray-300 rounded px-4 py-2 @error('department') border-red-500 @enderror" value="{{ old('department') }}" required>
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="salary" class="block mb-1 font-medium">Lương <span class="text-red-500">*</span></label>
                    <input type="text" name="salary_display" id="salary_display" class="w-full border border-gray-300 rounded px-4 py-2" value="{{ old('salary_display') }}" required oninput="formatSalary(this)">
                    <input type="hidden" name="salary" id="salary" value="{{ old('salary') }}">
                    @error('salary')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="hired_date" class="block mb-1 font-medium">Ngày vào làm <span class="text-red-500">*</span></label>
                    <input type="date" name="hired_date" id="hired_date" class="w-full border border-gray-300 rounded px-4 py-2 @error('hired_date') border-red-500 @enderror" value="{{ old('hired_date') }}" required>
                    @error('hired_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Trở lại</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Thêm nhân viên</button>
        </div>
    </form>
</div>

<script>
    function formatSalary(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = value ? new Intl.NumberFormat('vi-VN').format(value) : '';
        document.getElementById('salary').value = value;
    }

    document.getElementById('salary_display').addEventListener('blur', function() {
        let value = this.value.replace(/\D/g, '');
        document.getElementById('salary').value = value;
    });
</script>
@endsection
