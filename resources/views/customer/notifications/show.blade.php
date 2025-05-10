@extends('layouts.customer')

@section('title', 'Chi tiết thông báo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('customer.notifications.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách thông báo
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">{{ $notification->title }}</h1>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="prose max-w-none mb-6">
                {!! nl2br(e($notification->message)) !!}
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg mt-8">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Thông tin thêm</h3>
                <div class="flex items-center text-sm text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Trạng thái: Đã đọc</span>
                </div>
                
                @if($notification->created_at != $notification->updated_at)
                <div class="flex items-center text-sm text-gray-600 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Đã đánh dấu đọc lúc: {{ $notification->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
            
            <div class="flex justify-between mt-6">
                <a href="{{ route('customer.notifications.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                    Quay lại danh sách
                </a>
                <a href="{{ route('customer.profile') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Về trang cá nhân
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 