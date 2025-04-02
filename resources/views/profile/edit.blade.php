@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Thông Tin Cá Nhân</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Số Điện Thoại</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full p-2 border rounded-lg">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            💾 Cập nhật thông tin
        </button>
    </form>

    <h2 class="text-2xl font-semibold text-gray-700 mt-6">Đổi Mật Khẩu</h2>
    
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Mật khẩu mới</label>
            <input type="password" name="new_password" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" class="w-full p-2 border rounded-lg">
        </div>

        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            🔒 Đổi mật khẩu
        </button>
    </form>
</div>
@endsection
