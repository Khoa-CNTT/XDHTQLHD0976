@extends('layouts.admin')

@section('title', 'Gửi thông báo hàng loạt')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gửi thông báo hàng loạt</h1>
        <a href="{{ route('admin.notifications.index') }}" class="flex items-center text-gray-600 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm">Thông báo sẽ được gửi đến <strong>tất cả người dùng</strong> có tài khoản hoạt động.</p>
                <p class="text-sm mt-1">Hãy đảm bảo nội dung thông báo là phù hợp với mọi khách hàng.</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <div class="font-bold">Đã xảy ra lỗi:</div>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.mass-send') }}" class="space-y-6">
        @csrf
        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Nội dung thông báo</h2>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Tiêu đề thông báo <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" 
                    class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title') }}" 
                    placeholder="Nhập tiêu đề thông báo (ví dụ: Cập nhật chính sách)" required>
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
            <button type="submit" class="px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex items-center" onclick="return confirm('Bạn có chắc chắn muốn gửi thông báo này đến tất cả người dùng?')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
                Gửi thông báo hàng loạt
            </button>
        </div>
    </form>
</div>
@endsection 