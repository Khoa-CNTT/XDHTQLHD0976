@extends('layouts.admin')

@section('title', 'Chi tiết yêu cầu hỗ trợ')

@push('styles')
<style>
    /* Chat bubble animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .chat-bubble {
        animation: fadeIn 0.3s ease-out;
    }
    .chat-container {
        height: 500px;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .typing-indicator {
        display: flex;
        justify-content: flex-start;
        margin: 10px;
        display: none;
    }
    .typing-indicator span {
        height: 8px;
        width: 8px;
        background-color: #9E9EA1;
        border-radius: 50%;
        display: inline-block;
        margin: 0 1px;
        opacity: 0.4;
    }
    .typing-indicator span:nth-child(1) {
        animation: pulse 1s infinite ease-in-out;
    }
    .typing-indicator span:nth-child(2) {
        animation: pulse 1s infinite ease-in-out .2s;
    }
    .typing-indicator span:nth-child(3) {
        animation: pulse 1s infinite ease-in-out .4s;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.4; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(1); opacity: 0.4; }
    }
    .customer-chat-bubble {
        background-color: #f3f4f6;
        border-radius: 18px 18px 18px 4px;
    }
    .staff-chat-bubble {
        background-color: #dbeafe;
        border-radius: 18px 18px 4px 18px;
    }
    .message-time {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 3px;
        text-align: right;
    }
</style>
@endpush



@section('content')
<div class="container mx-auto mt-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.support.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
            <h2 class="text-2xl font-semibold mt-2">Yêu cầu hỗ trợ #{{ $ticket->id }}</h2>
        </div>
        
        <div class="flex space-x-3">
            <form action="{{ route('admin.support.update', $ticket->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="mr-2 border border-gray-300 rounded-lg text-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Chờ xử lý" {{ $ticket->status === 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="Đang xử lý" {{ $ticket->status === 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="Đã giải quyết" {{ $ticket->status === 'Đã giải quyết' ? 'selected' : '' }}>Đã giải quyết</option>
                    <option value="Đã huỷ" {{ $ticket->status === 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                    Cập nhật trạng thái
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Trò chuyện hỗ trợ -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Header của chat box -->
                <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $ticket->title }}</h2>
                        <div class="text-sm opacity-90 flex items-center">
                            <span>Từ: {{ $ticket->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-white 
                                @switch($ticket->status)
                                    @case('Chờ xử lý')
                                        text-yellow-800
                                        @break
                                    @case('Đang xử lý')
                                        text-blue-800
                                        @break
                                    @case('Đã giải quyết')
                                        text-green-800
                                        @break
                                    @case('Đã huỷ')
                                        text-red-800
                                        @break
                                    @default
                                        text-gray-800
                                @endswitch">
                                {{ $ticket->status }}
                            </span>
                        </div>
                    </div>
                    <div class="text-sm">
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                <!-- Khung chat -->
                <div id="chat-container" class="chat-container overflow-y-auto p-4 bg-gray-50">
                    <!-- Message ban đầu từ khách hàng -->
                    <div class="flex mb-4 chat-bubble" data-response-id="initial">
                        <div class="flex-shrink-0 mr-3">
                            <img src="{{ $ticket->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="customer-chat-bubble p-3 shadow-sm max-w-3xl">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium text-gray-900">
                                    {{ $ticket->user->name }}
                                    <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 text-xs rounded-full">Khách hàng</span>
                                </span>
                                <span class="text-xs text-gray-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="text-gray-700 whitespace-pre-wrap">
                                {!! nl2br(e($ticket->content)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Responses -->
                    <div id="responses-container">
                        @foreach($ticket->responses as $response)
                        <div class="flex mb-4 @if($response->isStaff()) justify-end @endif chat-bubble" data-response-id="{{ $response->id }}">
                            @if(!$response->isStaff())
                            <div class="flex-shrink-0 mr-3">
                                <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            </div>
                            @endif
                            
                            <div class="@if($response->isStaff()) staff-chat-bubble @else customer-chat-bubble @endif p-3 shadow-sm max-w-3xl">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium text-gray-900">
                                        {{ $response->user->name }}
                                        @if($response->isStaff())
                                        <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">Nhân viên</span>
                                        @else
                                        <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 text-xs rounded-full">Khách hàng</span>
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-gray-700 whitespace-pre-wrap">
                                    {!! nl2br(e($response->content)) !!}
                                </div>
                                <div class="message-time">
                                    @if($response->created_at->diffInMinutes(now()) < 60)
                                        {{ $response->created_at->diffForHumans() }}
                                    @endif
                                </div>
                            </div>
                            
                            @if($response->isStaff())
                            <div class="flex-shrink-0 ml-3">
                                <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Typing indicator -->
                    <div class="typing-indicator" id="typing-indicator">
                        <div class="flex items-center bg-gray-200 rounded-full py-1 px-3">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                
                <!-- Form phản hồi kiểu chatbox -->
                <div class="border-t p-4 bg-white">
                    <form id="response-form" action="{{ route('admin.support.respond', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="flex items-end">
                            <div class="flex-grow">
                                <textarea id="response" name="response" rows="3" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('response') border-red-500 @enderror" 
                                    placeholder="Nhập phản hồi của bạn..."></textarea>
                                @error('response')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="ml-3 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 flex items-center">
                                <span>Gửi</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Thông tin khách hàng -->
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Thông tin khách hàng</h3>
                <div class="flex items-center mb-4">
                    <img class="w-16 h-16 rounded-full mr-4 object-cover" src="{{ $ticket->user->getAvatarUrl() }}" alt="Avatar">
                    <div>
                        <p class="font-medium text-gray-800">{{ $ticket->user->name }}</p>
                        <p class="text-gray-600 text-sm">{{ $ticket->user->email }}</p>
                        <p class="text-gray-600 text-sm">{{ $ticket->user->phone }}</p>
                    </div>
                </div>
                <div class="mt-2 space-y-2 text-sm">
                    <p class="flex justify-between">
                        <span class="text-gray-500">Địa chỉ:</span>
                        <span class="text-gray-800">{{ $ticket->user->address }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-500">Công ty:</span>
                        <span class="text-gray-800">{{ $ticket->user->customer->company_name }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-500">Mã số thuế:</span>
                        <span class="text-gray-800">{{ $ticket->user->customer->tax_code }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-500">Ngày tham gia:</span>
                        <span class="text-gray-800">{{ $ticket->user->created_at->format('d/m/Y') }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Các yêu cầu hỗ trợ khác của khách hàng -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Yêu cầu khác của khách hàng</h3>
                @php
                    $otherTickets = \App\Models\SupportTicket::where('user_id', $ticket->user_id)
                                    ->where('id', '!=', $ticket->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();
                @endphp
                
                @if($otherTickets->count() > 0)
                    <ul class="space-y-3">
                        @foreach($otherTickets as $otherTicket)
                            <li class="border-b border-gray-100 pb-2">
                                <a href="{{ route('admin.support.show', $otherTicket->id) }}" class="hover:text-blue-600">
                                    <div class="font-medium text-gray-800 truncate">{{ $otherTicket->title }}</div>
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>{{ $otherTicket->created_at->format('d/m/Y') }}</span>
                                        <span class="px-2 py-0.5 rounded-full 
                                            @switch($otherTicket->status)
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
                                            {{ $otherTicket->status }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-center py-4">Không có yêu cầu hỗ trợ khác</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        
        // Submit form with AJAX
        const form = document.getElementById('response-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const response = document.getElementById('response').value;
                if (!response.trim()) return;
                
                const formData = new FormData(form);
                
                // Show typing indicator before sending
                document.getElementById('response').disabled = true;
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear the textarea
                        document.getElementById('response').value = '';
                        document.getElementById('response').disabled = false;
                        
                        // Add the new response to the chat
                        addNewResponse(data.response);
                        
                        // Scroll to the bottom
                        scrollToBottom();
                    } else {
                        document.getElementById('response').disabled = false;
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: data.message || 'Có lỗi xảy ra',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                })
                .catch(error => {
                    document.getElementById('response').disabled = false;
                    
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi gửi phản hồi',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            });
        }
        
        // Check for customer typing status
        setInterval(checkCustomerTyping, 5000);
        
        // Check for new responses
        setInterval(checkForNewCustomerResponses, 10000);
    });
    
    function scrollToBottom() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    function checkCustomerTyping() {
        // Kiểm tra xem khách hàng có đang gõ không
        fetch('{{ route("admin.support.check-typing", $ticket->id) }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.typing) {
                document.getElementById('typing-indicator').style.display = 'flex';
            } else {
                document.getElementById('typing-indicator').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error checking typing status:', error);
        });
    }
    
    function checkForNewCustomerResponses() {
        // Get the last response ID (if any)
        const lastResponseElement = document.querySelector('#responses-container > div:last-child');
        const lastResponseId = lastResponseElement ? lastResponseElement.dataset.responseId : 0;
        
        fetch(`{{ route('admin.support.check-responses', $ticket->id) }}?last_id=${lastResponseId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.responses.length > 0) {
                // There are new responses
                data.responses.forEach(response => {
                    addNewResponse(response);
                });
                
                // Scroll to bottom and show notification
                scrollToBottom();
                
                // Play notification sound
                const audio = new Audio('/sounds/notification.mp3');
                audio.play();
                
                // Show browser notification if page is not visible
                if (document.hidden && Notification.permission === "granted") {
                    const notification = new Notification('Phản hồi mới', {
                        body: 'Bạn có phản hồi mới từ khách hàng',
                        icon: '/images/logo.png'
                    });
                    
                    notification.onclick = function() {
                        window.focus();
                        notification.close();
                    };
                }
            }
        })
        .catch(error => {
            console.error('Error checking for new responses:', error);
        });
    }
    
    function addNewResponse(response) {
        const responsesContainer = document.getElementById('responses-container');
        
        // Create new response element
        const responseDiv = document.createElement('div');
        responseDiv.className = `flex mb-4 ${response.is_staff ? 'justify-end' : ''} chat-bubble`;
        responseDiv.dataset.responseId = response.id;
        
        let template = '';
        
        if (!response.is_staff) {
            template += `
                <div class="flex-shrink-0 mr-3">
                    <img src="${response.user_avatar}" alt="Avatar" class="w-10 h-10 rounded-full">
                </div>
            `;
        }
        
        template += `
            <div class="${response.is_staff ? 'staff-chat-bubble' : 'customer-chat-bubble'} p-3 shadow-sm max-w-3xl">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-medium text-gray-900">
                        ${response.user_name}
                        ${response.is_staff 
                            ? '<span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">Nhân viên</span>' 
                            : '<span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-800 text-xs rounded-full">Khách hàng</span>'}
                    </span>
                    <span class="text-xs text-gray-500">${response.created_at}</span>
                </div>
                <div class="text-gray-700 whitespace-pre-wrap">
                    ${response.content}
                </div>
                <div class="message-time">Vừa xong</div>
            </div>
        `;
        
        if (response.is_staff) {
            template += `
                <div class="flex-shrink-0 ml-3">
                    <img src="${response.user_avatar}" alt="Avatar" class="w-10 h-10 rounded-full">
                </div>
            `;
        }
        
        responseDiv.innerHTML = template;
        responsesContainer.appendChild(responseDiv);
    }
    
    // Request notification permission
    if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const responseInput = document.getElementById('response');
        const responseForm = document.getElementById('response-form');
        const typingIndicator = document.getElementById('typing-indicator');

        // Lắng nghe sự kiện nhập phím
        responseInput.addEventListener('input', function () {
            // Hiển thị dấu ba chấm khi đang nhập
            typingIndicator.style.display = 'flex';
            clearTimeout(responseInput.typingTimeout);
            responseInput.typingTimeout = setTimeout(() => {
                typingIndicator.style.display = 'none';
            }, 2000); // Ẩn sau 2 giây nếu không nhập
        });

        // Lắng nghe phím Enter để gửi tin nhắn
        responseInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault(); // Ngăn chặn xuống dòng
                responseForm.submit(); // Gửi biểu mẫu
            }
        });
    });
</script>

    
</script>
@endpush
@endsection 