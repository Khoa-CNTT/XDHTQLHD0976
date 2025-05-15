@extends('layouts.customer')

@section('title', 'Chi tiết yêu cầu hỗ trợ')

@push('styles')
<style>
    /* Chat bubble animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
   
    /* Chat Styles */
    .chat-container {
        height: 400px;
        overflow-y: auto;
        background-color: #f3f4f6;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        flex-direction: column-reverse;
    }
    .chat-bubble {
        max-width: 70%;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 15px;
        display: inline-block;
        animation: fadeIn 0.3s;
    }
    .customer-chat {
        background-color: #d1e7ff;
        margin-left: auto;
        text-align: right;
    }
    .staff-chat {
        background-color: #e2e8f0;
        margin-right: auto;
        text-align: left;
    }
    .typing-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    .typing-indicator span {
        background-color: #9ca3af;
        width: 6px;
        height: 6px;
        margin: 0 2px;
        border-radius: 50%;
        display: inline-block;
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 1; }
    }

</style>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $ticket->title }}</h1>
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
            </div>

            @if(!in_array($ticket->status, ['Đã giải quyết', 'Đã huỷ']))
            <div id="chat-container" class="chat-container overflow-y-auto p-4 bg-gray-50 rounded-lg">
                <div class="chat-content-container">
                    <div class="messages-container">
                        <!-- Initial message -->
                        <div class="flex mb-4 chat-bubble" data-response-id="initial">
                            <div class="avatar-container mr-3">
                                <img src="{{ $ticket->user->getAvatarUrl() }}" alt="Avatar" class="w-9 h-9 rounded-full">
                            </div>
                            <div class="staff-chat-bubble p-3 shadow-sm">
                                <div class="flex justify-between items-center mb-1 chat-header">
                                    <span class="chat-header-name text-gray-900">
                                        {{ $ticket->user->name }}
                                        <span class="ml-1 badge px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full">Bạn</span>
                                    </span>
                                    <span class="chat-header-time text-gray-500">{{ $ticket->created_at->format('H:i d/m/Y') }}</span>
                                </div>
                                <div class="text-gray-700 whitespace-pre-wrap message-text message-content">{{ $ticket->content }}</div>
                            </div>
                        </div>
                        
                        <!-- Responses -->
                        @foreach ($ticket->responses as $response)
                            <div class="flex mb-4 @if(!$response->isStaff()) justify-end @endif chat-bubble">
                                @if($response->isStaff())
                                    <div class="avatar-container mr-3">
                                        <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-9 h-9 rounded-full">
                                    </div>
                                @endif
                                <div class="@if(!$response->isStaff()) customer-chat-bubble @else staff-chat-bubble @endif p-3 shadow-sm">
                                    <div class="flex justify-between items-center mb-1 chat-header">
                                        <span class="chat-header-name text-gray-900">
                                            {{ $response->user->name }}
                                            @if(!$response->isStaff())
                                                <span class="ml-1 badge px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">Bạn</span>
                                            @else
                                                <span class="ml-1 badge px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full">Nhân viên</span>
                                            @endif
                                        </span>
                                        <span class="chat-header-time text-gray-500">{{ $response->created_at->format('H:i d/m/Y') }}</span>
                                    </div>
                                    <div class="text-gray-700 whitespace-pre-wrap message-text message-content">{{ $response->content }}</div>
                                    <div class="message-time">
                                        @if($response->created_at->diffInMinutes(now()) < 60)
                                            {{ $response->created_at->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>
                                @if(!$response->isStaff())
                                    <div class="avatar-container ml-3">
                                        <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-9 h-9 rounded-full">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Typing indicators -->
                    <div class="typing-indicator staff" id="staff-typing-indicator">
                        <div class="flex items-center staff-chat-bubble py-1 px-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    
                    <div class="typing-indicator customer" id="customer-typing-indicator">
                        <div class="flex items-center customer-chat-bubble py-1 px-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
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
        @else
            <div class="text-gray-500 italic mt-4">
                Yêu cầu đã {{ strtolower($ticket->status) }}. Bạn không thể gửi thêm phản hồi.
            </div>
        @endif

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-500">
            <p>Liên hệ hỗ trợ: <a href="mailto:support@example.com" class="text-blue-600 hover:underline">okamibada@gmail.com</a></p>
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
    const customerTypingIndicator = document.getElementById('customer-typing-indicator');
    const staffTypingIndicator = document.getElementById('staff-typing-indicator');
    const responseInput = document.getElementById('response');
    
    responseInput.addEventListener('input', () => {
        customerTypingIndicator.style.display = 'flex';
        setTimeout(() => customerTypingIndicator.style.display = 'none', 2000);
    });

    // Kiểm tra xem nhân viên có đang gõ không
    function checkStaffTyping() {
        // Đây là chức năng giả định - bạn cần thay thế bằng API call thực tế
        fetch('', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.typing) {
                staffTypingIndicator.style.display = 'flex';
                setTimeout(() => staffTypingIndicator.style.display = 'none', 3000);
            }
        })
        .catch(error => {
            console.error('Error checking typing status:', error);
        });
    }
    
    // Gọi hàm kiểm tra typing của nhân viên định kỳ
    setInterval(checkStaffTyping, 5000);

    // Gửi tin nhắn bằng phím Enter
    responseInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('response-form').submit();
        }
    });
    
    // Kiểm tra tin nhắn mới
    function checkForNewResponses() {
        // Đây là chức năng giả định - bạn cần thay thế bằng API call thực tế
        fetch('{{ route("customer.support.check-responses", $ticket->id) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.hasNewResponses) {
                // Reload trang hoặc thêm tin nhắn mới vào chat
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error checking for new responses:', error);
        });
    }
    
    // Gọi hàm kiểm tra tin nhắn mới định kỳ
    setInterval(checkForNewResponses, 10000);
</script>
@endsection