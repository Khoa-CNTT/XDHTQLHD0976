@extends('layouts.customer')

@section('title', 'Trang Cá Nhân')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white  rounded-lg mt-6">
        <h1 class="text-4xl font-bold mb-8 text-center mt-2 text-black">
             Thông Tin Cá Nhân
         </h1>
        <!-- Success and Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-md mb-6">
                <strong class="font-bold">Thành công!</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-md mb-6">
                <strong class="font-bold">Lỗi!</strong>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-md mb-6">
                <strong class="font-bold">Có lỗi!</strong>
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabs -->
        <div class="grid w-full grid-cols-2 bg-gray-200 dark:bg-gray-800 mb-6 rounded-lg overflow-hidden">
            <button id="info-tab"
                class="p-4 text-gray-800 bg-purple-600 text-white font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-600 transition"
                onclick="showTab('info')">
                Thông Tin Cá Nhân
            </button>
            <button id="password-tab"
                class="p-4 text-gray-800 bg-gray-300 font-medium hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition"
                onclick="showTab('password')">
                Đổi Mật Khẩu
            </button>
        </div>

        <!-- Tab Contents -->
        <div class="w-full">
            {{-- Thông Tin Cá Nhân Tab --}}
            <div id="info-content" class="bg-white rounded-lg border-2 shadow-md p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Cập nhật thông tin cá nhân</h2>
                <form id="personal-info-form" action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-700">Tên</label>
                            <input type="text" id="name" name="name" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" value="{{ auth()->user()->name }}" required>
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" value="{{ auth()->user()->email }}" required>
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" value="{{ auth()->user()->phone }}" required>
                            @error('phone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-gray-700">Địa chỉ</label>
                            <input type="text" id="address" name="address" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" value="{{ auth()->user()->address }}" required>
                            @error('address')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition duration-300 w-full">
                            Cập nhật thông tin
                        </button>
                    </div>
                </form>
            </div>

            {{-- Đổi Mật Khẩu Tab --}}
            <div id="password-content" class="bg-white rounded-lg border-2 shadow-md p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Đổi mật khẩu</h2>
                <form id="change-password-form" action="{{ route('customer.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="old-password" class="block text-gray-700">Mật khẩu cũ</label>
                            <input type="password" id="old-password" name="old_password" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" required>
                            @error('old_password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="new-password" class="block text-gray-700">Mật khẩu mới</label>
                            <input type="password" id="new-password" name="new_password" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" required>
                            @error('new_password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="confirm-password" class="block text-gray-700">Xác nhận mật khẩu mới</label>
                            <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-purple-600" required>
                            @error('new_password_confirmation')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition duration-300 w-full">
                            Đổi mật khẩu
                        </button>
                    </div>
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
            infoTab.classList.add('bg-purple-600', 'text-white', 'hover:bg-purple-700');
            infoTab.classList.remove('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            passwordTab.classList.add('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            passwordTab.classList.remove('bg-purple-600', 'text-white', 'hover:bg-purple-700');

            infoContent.classList.remove('hidden');
            passwordContent.classList.add('hidden');
        } else {
            passwordTab.classList.add('bg-purple-600', 'text-white', 'hover:bg-purple-700');
            passwordTab.classList.remove('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            infoTab.classList.add('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            infoTab.classList.remove('bg-purple-600', 'text-white', 'hover:bg-purple-700');

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
            @else
                showTab('info'); 
            @endif
        });
    </script>
    
@endsection
