@extends('layouts.customer')

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
    .message-time {
        font-size: 0.7rem;
        color: #6b7280;
        margin-top: 3px;
        text-align: right;
    }
    /* Emoji picker styles */
    .emoji-button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.5rem;
        color: #6b7280;
        transition: color 0.2s;
    }
    .emoji-button:hover {
        color: #4b5563;
    }
    .emoji-picker {
        position: absolute;
        bottom: 70px;
        right: 20px;
        z-index: 100;
        display: none;
    }
</style>
@endpush

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
<div class="container mx-auto mt-6">
    <div class="mb-4">
        <a href="{{ route('customer.support.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header của chat box -->
        <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold">{{ $ticket->title }}</h2>
                <div class="text-sm opacity-90 flex items-center">
                    <span>Yêu cầu #{{ $ticket->id }}</span>
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
            <div class="text-sm flex items-center space-x-2">
                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                <!-- Trạng thái online -->
                <div class="flex items-center">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-xs ml-1">Đang hoạt động</span>
                </div>
            </div>
        </div>
        
        <!-- Khung chat -->
        <div id="chat-container" class="chat-container overflow-y-auto p-4 bg-gray-50">
            <!-- Message ban đầu từ khách hàng -->
            <div class="flex mb-4 chat-bubble" data-response-id="initial">
                <div class="flex-shrink-0 mr-3">
                    <img src="{{ $ticket->user->getAvatarUrl() }}" alt="Avatar" class="w-10 h-10 rounded-full">
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm max-w-3xl">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-medium text-gray-900">{{ $ticket->user->name }}</span>
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
                    
                    <div class="@if($response->isStaff()) bg-blue-100 @else bg-white @endif p-3 rounded-lg shadow-sm max-w-3xl">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-900">
                                {{ $response->user->name }}
                                @if($response->isStaff())
                                <span class="ml-2 px-2 py-0.5 bg-blue-200 text-blue-800 text-xs rounded-full">Nhân viên</span>
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
        @if($ticket->status != 'Đã giải quyết' && $ticket->status != 'Đã huỷ')
        <div class="border-t p-4 bg-white relative">
            <form id="response-form" action="{{ route('customer.support.respond', $ticket->id) }}" method="POST">
                @csrf
                <div class="flex items-end">
                    <div class="flex-grow relative">
                        <textarea id="response" name="response" rows="2" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('response') border-red-500 @enderror" 
                            placeholder="Nhập tin nhắn của bạn..."></textarea>
                        @error('response')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div class="absolute right-2 bottom-2">
                            <button type="button" id="emoji-button" class="emoji-button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="ml-3 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 flex items-center">
                        <span>Gửi</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </form>
            <!-- Emoji picker container -->
            <div id="emoji-picker" class="emoji-picker">
                <!-- Will be filled by JavaScript -->
            </div>
        </div>
        @else
        <div class="p-4 bg-yellow-50 border-t border-yellow-200 text-center">
            <p class="flex items-center justify-center text-yellow-700">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Yêu cầu hỗ trợ này đã {{ $ticket->status == 'Đã giải quyết' ? 'được giải quyết' : 'bị huỷ bỏ' }}, bạn không thể gửi thêm tin nhắn.
            </p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Scroll to bottom of chat container initially
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        
        // Simple emoji picker
        const emojiButton = document.getElementById('emoji-button');
        const emojiPicker = document.getElementById('emoji-picker');
        const textArea = document.getElementById('response');
        
        if (emojiButton) {
            // Common emojis array
            const commonEmojis = [
                '😊', '😀', '🙂', '👍', '👌', '✅', '🎉', '👏', '🙏', 
                '❤️', '👨‍💻', '📝', '📊', '⭐', '🔍', '💼', '📱', '🤔', '😕'
            ];
            
            // Create emoji picker
            if (emojiPicker) {
                let emojiHTML = '<div class="bg-white rounded-lg shadow-lg p-2 grid grid-cols-5 gap-1">';
                commonEmojis.forEach(emoji => {
                    emojiHTML += `<button type="button" class="emoji p-2 hover:bg-gray-100 rounded">${emoji}</button>`;
                });
                emojiHTML += '</div>';
                emojiPicker.innerHTML = emojiHTML;
                
                // Toggle emoji picker
                emojiButton.addEventListener('click', function() {
                    emojiPicker.style.display = emojiPicker.style.display === 'block' ? 'none' : 'block';
                });
                
                // Insert emoji on click
                emojiPicker.querySelectorAll('.emoji').forEach(emoji => {
                    emoji.addEventListener('click', function() {
                        const cursorPos = textArea.selectionStart;
                        const text = textArea.value;
                        const newText = text.slice(0, cursorPos) + this.textContent + text.slice(cursorPos);
                        textArea.value = newText;
                        textArea.focus();
                        emojiPicker.style.display = 'none';
                    });
                });
                
                // Close emoji picker when clicking outside
                document.addEventListener('click', function(e) {
                    if (!emojiButton.contains(e.target) && !emojiPicker.contains(e.target)) {
                        emojiPicker.style.display = 'none';
                    }
                });
            }
        }
        
        // Submit form with AJAX
        const form = document.getElementById('response-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const response = document.getElementById('response').value;
                if (!response.trim()) return;
                
                const formData = new FormData(form);
                
                // Show typing indicator before sending
                document.getElementById('typing-indicator').style.display = 'flex';
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
                        
                        // Hide typing indicator
                        document.getElementById('typing-indicator').style.display = 'none';
                        
                        // Add the new response to the chat
                        addNewResponse(data.response);
                        
                        // Scroll to the bottom
                        scrollToBottom();
                        
                        // Fake staff typing after a small delay
                        if (Math.random() > 0.5) {
                            setTimeout(() => {
                                showTypingIndicator();
                            }, 2000);
                        }
                    } else {
                        document.getElementById('response').disabled = false;
                        document.getElementById('typing-indicator').style.display = 'none';
                        
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
                    document.getElementById('typing-indicator').style.display = 'none';
                    
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
        
        // Poll for new responses every 10 seconds
        setInterval(checkForNewResponses, 10000);
        
        // Add event listener for textarea to show "typing" status
        const textarea = document.getElementById('response');
        if (textarea) {
            let typingTimer;
            const doneTypingInterval = 1000;
            
            textarea.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                if (textarea.value) {
                    // Send typing status to server
                    fetch('{{ route("customer.support.typing", $ticket->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ typing: true })
                    });
                    
                    typingTimer = setTimeout(function() {
                        // Send stopped typing status
                        fetch('{{ route("customer.support.typing", $ticket->id) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ typing: false })
                        });
                    }, doneTypingInterval);
                }
            });
        }
    });
    
    function showTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        typingIndicator.style.display = 'flex';
        
        // Hide after random time between 2-5 seconds
        setTimeout(() => {
            typingIndicator.style.display = 'none';
        }, 2000 + Math.random() * 3000);
    }
    
    function scrollToBottom() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;
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
            <div class="${response.is_staff ? 'bg-blue-100' : 'bg-white'} p-3 rounded-lg shadow-sm max-w-3xl">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-medium text-gray-900">
                        ${response.user_name}
                        ${response.is_staff ? '<span class="ml-2 px-2 py-0.5 bg-blue-200 text-blue-800 text-xs rounded-full">Nhân viên</span>' : ''}
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
    
    function checkForNewResponses() {
        // Get the last response ID (if any)
        const lastResponseElement = document.querySelector('#responses-container > div:last-child');
        const lastResponseId = lastResponseElement ? lastResponseElement.dataset.responseId : 0;
        
        fetch(`{{ route('customer.support.check-responses', $ticket->id) }}?last_id=${lastResponseId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.responses.length > 0) {
                // Show typing indicator first
                showTypingIndicator();
                
                // There are new responses
                setTimeout(() => {
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
                            body: 'Bạn có phản hồi mới từ nhân viên hỗ trợ',
                            icon: '/images/logo.png'
                        });
                        
                        notification.onclick = function() {
                            window.focus();
                            notification.close();
                        };
                    }
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error checking for new responses:', error);
        });
    }
    
    // Request notification permission
    if (Notification.permission !== "granted" && Notification.permission !== "denied") {
        Notification.requestPermission();
    }
</script>
@endpush
@endsection 