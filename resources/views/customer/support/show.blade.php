@extends('layouts.customer')

@section('title', 'Chi tiết yêu cầu hỗ trợ')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Chi tiết yêu cầu hỗ trợ #{{ $ticket->id }}</h1>
                    <p class="text-gray-600 mt-1">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($ticket->status === 'Chờ xử lý') bg-yellow-100 text-yellow-800
                        @elseif($ticket->status === 'Đang xử lý') bg-blue-100 text-blue-800
                        @elseif($ticket->status === 'Đã trả lời') bg-green-100 text-green-800
                        @elseif($ticket->status === 'Đã đóng') bg-gray-100 text-gray-800
                        @endif">
                        {{ $ticket->status }}
                    </span>
                </div>
            </div>
            <!-- Nút Trở về -->
            <a href="{{ route('customer.support.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                ← Trở về danh sách yêu cầu
            </a>
        </div>

        <!-- Chat Container -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Trò chuyện với nhân viên hỗ trợ</h2>
                <span class="text-sm text-green-600">Nhân viên hỗ trợ đang trực tuyến</span>
            </div>
            <div id="chat-container" class="chat-container overflow-y-auto h-96 p-4 bg-gray-50 rounded-lg">
                @foreach ($ticket->responses as $response)
                    <div class="flex mb-4 @if($response->isStaff()) justify-end @endif">
                        @if(!$response->isStaff())
                            <div class="flex-shrink-0 mr-3">
                                <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            </div>
                        @endif
                        <div class="@if($response->isStaff()) bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif p-3 rounded-lg shadow-sm max-w-lg">
                            <div class="text-sm">
                                <span class="font-medium">{{ $response->user->name }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $response->created_at->format('H:i d/m/Y') }}</span>
                            </div>
                            <p class="mt-1">{{ $response->content }}</p>
                        </div>
                        @if($response->isStaff())
                            <div class="flex-shrink-0 ml-3">
                                <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Typing Indicator -->
            <div id="typing-indicator" class="hidden mt-4">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                </div>
            </div>

            <!-- Reply Form -->
            @if($ticket->status !== 'Đã đóng')
                <form id="response-form" action="{{ route('customer.support.respond', $ticket->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <textarea id="response" name="response" rows="1" class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Nhập tin nhắn của bạn..."></textarea>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="px-2 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                😊
                            </button>
                            <button type="button" class="px-2 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                📎
                            </button>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Gửi
                        </button>
                    </div>
                </form>
            @else
                <div class="mt-4 text-center text-gray-500">
                    Yêu cầu hỗ trợ này đã được đóng.
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-500">
            <p>Liên hệ hỗ trợ: <a href="mailto:support@example.com" class="text-blue-600 hover:underline">support@example.com</a></p>
            <p>Hoặc gọi: <a href="tel:+123456789" class="text-blue-600 hover:underline">+123 456 789</a></p>
        </div>
    </div>
</div>

<script>
    // Tự động cuộn xuống cuối khung chat khi có tin nhắn mới
    function scrollToBottom() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    scrollToBottom();

    // Hiển thị trạng thái "Đang gõ..."
    const typingIndicator = document.getElementById('typing-indicator');
    const responseInput = document.getElementById('response');
    responseInput.addEventListener('input', () => {
        typingIndicator.classList.remove('hidden');
        setTimeout(() => typingIndicator.classList.add('hidden'), 2000);
    });

    // Gửi tin nhắn bằng phím Enter
    responseInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('response-form').submit();
        }
    });
</script>
@endsection