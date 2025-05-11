@extends('layouts.customer')

@section('title', 'Chi tiết thông báo')

@push('styles')
<style>
    .notification-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(226, 232, 240, 1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        background: linear-gradient(to bottom, #ffffff, #f9fafb);
    }

    .action-button {
        transition: all 0.2s ease;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
    }
    
    .back-button {
        transition: all 0.2s ease;
    }
    
    .back-button:hover {
        transform: translateX(-2px);
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .notification-header {
        border-bottom: 1px solid rgba(226, 232, 240, 1);
        position: relative;
    }
    
    .notification-header:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, #3182ce, #63b3ed);
        border-radius: 3px;
    }
    
    .notification-content {
        line-height: 1.8;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        line-height: 1;
        transition: all 0.2s ease;
    }
    
    .badge:hover {
        transform: scale(1.05);
    }
    
    .badge-success {
        background-color: rgba(209, 250, 229, 1);
        color: rgba(6, 95, 70, 1);
    }
    
    .meta-info {
        background: rgba(249, 250, 251, 1);
        border-radius: 0.5rem;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 animate-fade-in">
                <a href="{{ route('customer.notifications.index') }}" class="back-button inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Quay lại danh sách thông báo
                </a>
            </div>
            
            <div class="notification-card bg-white p-8 rounded-xl mb-10 animate-fade-in-up">
                <div class="notification-header mb-6 pb-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-3">
                        <span class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            {{ $notification->title }}
                        </span>
                    </h1>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                
                <div class="notification-content prose max-w-none mb-8 text-gray-700 leading-relaxed">
                    <div class="p-1">
                        {!! nl2br(e($notification->message)) !!}
                    </div>
                </div>
                
                <div class="meta-info p-5 rounded-lg mt-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Thông tin thêm
                    </h3>
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <span class="badge badge-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Đã đọc
                        </span>
                    </div>
                    
                    @if($notification->created_at != $notification->updated_at)
                    <div class="flex items-center text-sm text-gray-600 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Đã đánh dấu đọc lúc: {{ $notification->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="flex justify-between mt-8 space-x-4">
                    <a href="{{ route('customer.notifications.index') }}" class="action-button flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Quay lại danh sách
                    </a>
                    <a href="{{ route('customer.profile') }}" class="action-button flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Về trang cá nhân
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 