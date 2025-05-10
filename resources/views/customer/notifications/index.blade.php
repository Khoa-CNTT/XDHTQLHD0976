@extends('layouts.customer')

@section('title', 'Quản lý thông báo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Thông báo của tôi</h1>
            
            @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('customer.notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-200">
                    Đánh dấu tất cả đã đọc
                </button>
            </form>
            @endif
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($notifications->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <li class="p-5 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $notification->title }}</h3>
                                        <span class="text-xs text-gray-500">{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="mt-1 text-gray-600">{{ $notification->message }}</p>
                                    @if(!$notification->is_read)
                                        <div class="mt-3">
                                            <a href="{{ route('customer.notifications.show', $notification->id) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                Đánh dấu đã đọc
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-4 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>Bạn chưa có thông báo nào.</p>
                </div>
            @endif
        </div>
        
        <div class="mt-6">
            <a href="{{ route('customer.profile') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay lại trang cá nhân
            </a>
        </div>
    </div>
</div>
@endsection 