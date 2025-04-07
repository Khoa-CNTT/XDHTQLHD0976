@extends('layouts.customer')

@section('title', 'Trang Cá Nhân')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-center mt-2 text-black">
            Thông Tin Cá Nhân
        </h1>

        <!-- Success and Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="w-full">
            <div class="grid w-full grid-cols-2 dark:bg-gray-800 rounded-lg mb-6">
                <button id="info-tab" class="p-4 dark:text-white dark:bg-purple-600" onclick="showTab('info')">Thông Tin Cá Nhân</button>
                <button id="password-tab" class="p-4 dark:text-white" onclick="showTab('password')">Đổi Mật Khẩu</button>
            </div>

            {{-- Tab Thông Tin  --}}
            <div id="info-content" class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Thông Tin Cá Nhân</h2>
                <form id="personal-info-form" action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Tên:</label>
                        <input type="text" id="name" name="name" class="w-full p-2 border rounded" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border rounded" value="{{ auth()->user()->email }}" required>
                        @error('email')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Số Điện Thoại</label>
                        <input type="text" id="phone" name="phone" class="w-full p-2 border rounded" value="{{ auth()->user()->phone }}" required>
                        @error('phone')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700">Địa chỉ:</label>
                        <input type="text" id="address" name="address" class="w-full p-2 border rounded" value="{{ auth()->user()->address }}" required>
                        @error('address')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Cập Nhật Thông Tin</button>
                </form>
            </div>

            {{-- Tab Đổi Mật Khẩu --}}
            <div id="password-content" class="bg-white rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Đổi Mật Khẩu</h2>
                <form id="change-password-form" action="{{ route('customer.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="old-password" class="block text-gray-700">Mật Khẩu Cũ:</label>
                        <input type="password" id="old-password" name="old_password" class="w-full p-2 border rounded" required>
                        @error('old_password')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="new-password" class="block text-gray-700">Mật Khẩu Mới:</label>
                        <input type="password" id="new-password" name="new_password" class="w-full p-2 border rounded" required>
                        @error('new_password')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="confirm-password" class="block text-gray-700">Xác Nhận Mật Khẩu Mới:</label>
                        <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full p-2 border rounded" required>
                        @error('new_password_confirmation')
                            <div class="text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Đổi Mật Khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            const infoTab = document.getElementById('info-tab');
            const passwordTab = document.getElementById('password-tab');
            const infoContent = document.getElementById('info-content');
            const passwordContent = document.getElementById('password-content');

            if (tab === 'info') {
                infoTab.classList.add('dark:bg-purple-600');
                passwordTab.classList.remove('dark:bg-purple-600');
                infoContent.classList.remove('hidden');
                passwordContent.classList.add('hidden');
            } else {
                passwordTab.classList.add('dark:bg-purple-600');
                infoTab.classList.remove('dark:bg-purple-600');
                passwordContent.classList.remove('hidden');
                infoContent.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success') || session('error'))
                @if (session('tab') === 'password')
                    showTab('password');
                @else
                    showTab('info');
                @endif
            @endif
        });
    </script>
@endsection