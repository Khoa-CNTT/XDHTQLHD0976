@extends('layouts.admin')

@section('title', 'Tạo thông báo mới')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tạo thông báo mới</h1>
        <a href="{{ route('admin.notifications.index') }}" class="flex items-center text-gray-600 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
        <div class="font-bold">Đã xảy ra lỗi:</div>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-6">
        @csrf
        
        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Thông tin người nhận</h2>
            
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Chọn người nhận <span class="text-red-500">*</span>
                </label>
                <select name="user_id" id="user_id" class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('user_id') border-red-500 @enderror" required>
                    <option value="">-- Chọn người nhận --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Nội dung thông báo</h2>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Tiêu đề thông báo <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" 
                    class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title') }}" 
                    placeholder="Nhập tiêu đề thông báo (ví dụ: Cập nhật dịch vụ mới)" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Nội dung chi tiết <span class="text-red-500">*</span>
                </label>
                <textarea name="message" id="message" rows="6" 
                    class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror" 
                    placeholder="Nhập nội dung chi tiết của thông báo..." required>{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.notifications.index') }}" class="px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Hủy
            </a>
            <button type="submit" class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Gửi thông báo
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // If you need to initialize any scripts for this page, add them here
    });
</script>
@endpush 