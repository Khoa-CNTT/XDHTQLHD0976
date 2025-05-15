@extends('layouts.admin')

@section('title', 'Thông Tin Cá Nhân')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-semibold mb-6">Thông Tin Cá Nhân</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Thông tin cá nhân và avatar -->
        <div class="col-span-1 bg-gray-50 rounded-lg p-6 shadow-sm order-2 md:order-1">
            <div class="flex flex-col items-center">
                <div class="relative group mb-4">
                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <button type="button" onclick="document.getElementById('avatar-upload').click()" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <form id="avatar-form" action="{{ route('admin.profile.update-avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                   <input 
    type="file" 
    name="avatar" 
    id="avatar-upload" 
    class="hidden"
    onchange="if(this.files.length) document.getElementById('avatar-form').submit();"
>
                </form>
                
                <h2 class="text-xl font-bold text-gray-800 mb-3">{{ $user->name }}</h2>
                <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                <div class="text-center text-gray-600 text-sm">
                    <p class="mb-1"><span class="font-semibold">Vị trí:</span> {{ $employee->position ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Phòng ban:</span> {{ $employee->department ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Đổi Mật Khẩu</h3>
                <form action="{{ route('admin.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại <span class="text-red-500">*</span></label>
                            <input 
                                type="password" 
                                name="current_password" 
                                id="current_password" 
                                class="w-full px-3 py-2 border @error('current_password') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                required
                            >
                            @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới <span class="text-red-500">*</span></label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                required
                            >
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="text-xs text-gray-500 mt-1">
                                <p>Mật khẩu phải có ít nhất:</p>
                                <ul class="list-disc pl-4 mt-1">
                                    <li>8 ký tự</li>
                                    <li>1 chữ cái hoa</li>
                                    <li>1 chữ cái thường</li>
                                    <li>1 số</li>
                                    <li>1 ký tự đặc biệt (@$!%*#?&)</li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới <span class="text-red-500">*</span></label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cập nhật thông tin cá nhân -->
        <div class="md:col-span-2 bg-gray-50 rounded-lg p-6 shadow-sm order-1 md:order-2">
            <h2 class="text-xl font-semibold mb-6 border-b pb-2">Thông Tin Nhân Viên</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                        <p class="mt-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-gray-700">{{ $user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-gray-700">{{ $user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vị trí</label>
                        <p class="mt-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-gray-700">{{ $employee->position ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phòng ban</label>
                        <p class="mt-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-gray-700">{{ $employee->department ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày bắt đầu làm việc</label>
                        <p class="mt-1 px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-gray-700">
                            {{ $employee->hired_date ? date('d/m/Y', strtotime($employee->hired_date)) : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Cập nhật thông tin liên hệ</h3>
            
            <!-- Form cập nhật thông tin liên hệ -->
            <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}" 
                            class="w-full px-3 py-2 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Nhập số điện thoại (10 số)"
                            required
                        >
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address" 
                            value="{{ old('address', $user->address) }}" 
                            class="w-full px-3 py-2 border @error('address') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Nhập địa chỉ đầy đủ"
                            required
                        >
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Cập nhật thông tin
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success') || session('error') || session('info'))
    <div id="notification" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto relative z-10">
            <div class="text-center">
                @if(session('success'))
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Thành công!</h3>
                    <p class="text-gray-600">{{ session('success') }}</p>
                @endif
                
                @if(session('error'))
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Lỗi!</h3>
                    <p class="text-gray-600">{{ session('error') }}</p>
                @endif
                
                @if(session('info'))
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Thông báo!</h3>
                    <p class="text-gray-600">{{ session('info') }}</p>
                @endif
                
                <button id="closeNotification" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Đóng
                </button>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý đóng thông báo popup
        const notificationElement = document.getElementById('notification');
        const closeButton = document.getElementById('closeNotification');
        
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                notificationElement.classList.add('hidden');
            });
            
            // Tự động đóng thông báo sau 3 giây
            setTimeout(function() {
                notificationElement.classList.add('hidden');
            }, 3000);
        }
    });
</script>
@endpush