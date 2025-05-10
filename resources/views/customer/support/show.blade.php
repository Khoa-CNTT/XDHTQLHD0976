@extends('layouts.customer')

@section('title', 'Chi tiết yêu cầu hỗ trợ')

@if(session()->has('success'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endpush
@endif

@section('content')
<div class="container mx-auto mt-8">
    <div class="mb-6">
        <a href="{{ route('customer.support.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại danh sách
        </a>
        <h2 class="text-2xl font-semibold mt-2">Chi tiết yêu cầu hỗ trợ #{{ $ticket->id }}</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $ticket->title }}</h3>
                <div class="flex items-center text-sm text-gray-500">
                    <span>Ngày tạo: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    <span class="mx-2">•</span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                        @switch($ticket->status)
                            @case('Chờ xử lý')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('Đang xử lý')
                                bg-blue-100 text-blue-800
                                @break
                            @case('Đã giải quyết')
                                bg-green-100 text-green-800
                                @break
                            @case('Đã huỷ')
                                bg-red-100 text-red-800
                                @break
                            @default
                                bg-gray-100 text-gray-800
                        @endswitch">
                        {{ $ticket->status }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="prose max-w-none">
            {!! nl2br(e($ticket->content)) !!}
        </div>
    </div>
    
    <!-- Phản hồi -->
    @if($ticket->responses->count() > 0)
    <div class="bg-white rounded-lg shadow-md mb-6 divide-y divide-gray-200">
        <div class="p-4 bg-gray-50">
            <h3 class="font-semibold text-gray-700">Phản hồi ({{ $ticket->responses->count() }})</h3>
        </div>
        
        @foreach($ticket->responses as $response)
        <div class="p-4 @if($response->isStaff()) bg-blue-50 @endif">
            <div class="flex">
                <div class="mr-3">
                    <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <span class="font-medium text-gray-800">{{ $response->user->name }}</span>
                            @if($response->isStaff())
                            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">Nhân viên</span>
                            @else
                            <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 text-xs rounded-full">Bạn</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="text-gray-700">
                        {!! nl2br(e($response->content)) !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Form phản hồi -->
    @if($ticket->status != 'Đã giải quyết' && $ticket->status != 'Đã huỷ')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Gửi phản hồi của bạn</h3>
        <form action="{{ route('customer.support.respond', $ticket->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="response" class="block text-sm font-medium text-gray-700 mb-1">Nội dung phản hồi</label>
                <textarea id="response" name="response" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('response') border-red-500 @enderror" placeholder="Nhập nội dung phản hồi..."></textarea>
                @error('response')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Gửi phản hồi
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4 rounded">
        <p class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Yêu cầu hỗ trợ này đã được {{ $ticket->status == 'Đã giải quyết' ? 'giải quyết' : 'huỷ bỏ' }}, bạn không thể gửi thêm phản hồi.
        </p>
    </div>
    @endif
</div>
@endsection 