@extends('layouts.customer')

@section('title', 'Chi tiết yêu cầu hỗ trợ')

@push('styles')
<style>
    /* STYLE HOÀN TOÀN MỚI CHO KHUNG CHAT GIỐNG FACEBOOK */
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
        background-color: white;
        border-radius: 0.5rem;
    }
    
    .chat-header {
        background-color: #3b82f6;
        color: white;
        padding: 16px;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    
    .chat-container {
        height: 450px;
        overflow-y: auto;
        padding: 16px;
        background-color: #f8fafc;
        flex: 1;
        border-right: 1px solid #e5e7eb;
        border-left: 1px solid #e5e7eb;
    }
    
    .chat-footer {
        border: 1px solid #e5e7eb;
        border-top: none;
        padding: 12px;
        background-color: white;
        display: flex;
        align-items: center;
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    
    .message {
        display: flex;
        margin-bottom: 16px;
        align-items: flex-start;
    }
    
    .message.staff {
        justify-content: flex-end;
    }
    
    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    .message.staff .message-avatar {
        margin-right: 0;
        margin-left: 8px;
    }
    
    .message-bubble {
        max-width: 75%;
        border-radius: 18px;
        padding: 8px 12px;
        position: relative;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .customer-bubble {
        background-color: white;
        border: 1px solid #e5e7eb;
        border-top-left-radius: 4px;
    }
    
    .staff-bubble {
        background-color: #e9f0ff;
        border-top-right-radius: 4px;
    }
    
    .message-content {
        font-size: 0.95rem;
        line-height: 1.4;
        word-break: break-word;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #6b7280;
        text-align: right;
        margin-top: 4px;
    }
    
    .message-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }
    
    .message-sender {
        font-weight: 500;
        font-size: 0.85rem;
        color: #374151;
    }
    
    .message-timestamp {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .staff-badge {
        display: inline-block;
        background-color: #dbeafe;
        color: #1e40af;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 4px;
    }
    
    .chat-input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 24px;
        padding: 8px 12px;
        padding-right: 40px;
        resize: none;
        max-height: 100px;
        min-height: 40px;
    }
    
    .chat-input:focus {
        outline: none;
        border-color: #3b82f6;
    }
    
    .emoji-button {
        position: absolute;
        right: 90px;
        background: none;
        border: none;
        color: #6b7280;
        font-size: 1.25rem;
        cursor: pointer;
    }
    
    .emoji-button:hover {
        color: #4b5563;
    }
    
    .send-button {
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 24px;
        padding: 8px 16px;
        margin-left: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .send-button:hover {
        background-color: #2563eb;
    }
    
    .typing-indicator {
        display: none;
        margin: 0 0 16px 44px;
    }
    
    .typing-bubble {
        background-color: #e5e7eb;
        padding: 8px 16px;
        border-radius: 18px;
        display: inline-block;
    }
    
    .typing-bubble span {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #9ca3af;
        border-radius: 50%;
        margin: 0 1px;
        animation: typing-bubble 1s infinite ease-in-out;
    }
    
    .typing-bubble span:nth-child(1) {
        animation-delay: 0s;
    }
    
    .typing-bubble span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-bubble span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typing-bubble {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    
    /* Custom scrollbar */
    .chat-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .chat-container::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 10px;
    }
    
    /* For Firefox */
    .chat-container {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
    }
    
    /* For mobile devices */
    @media (max-width: 640px) {
        .message-bubble {
            max-width: 85%;
        }
        
        .chat-container {
            height: 400px;
        }
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
<div class="container mx-auto mt-6 px-4 md:px-0 mb-10">
    <div class="mb-4">
        <a href="{{ route('customer.support.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="max-w-3xl mx-auto shadow-md rounded-lg overflow-hidden">
        <!-- Khung chat kiểu Facebook -->
        <div class="chat-wrapper">
            <!-- Header -->
            <div class="chat-header">
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
            
            <!-- Khung chat chính -->
            <div id="chat-container" class="chat-container">
                <!-- Message ban đầu từ khách hàng -->
                <div class="message" data-response-id="initial">
                    <img src="{{ $ticket->user->getAvatarUrl() }}" alt="Avatar" class="message-avatar">
                    <div class="message-bubble customer-bubble">
                        <div class="message-meta">
                            <span class="message-sender">{{ $ticket->user->name }}</span>
                            <span class="message-timestamp">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="message-content">
                            {!! nl2br(e($ticket->content)) !!}
                        </div>
                    </div>
                </div>
                
                <!-- Responses -->
                <div id="responses-container">
                    @foreach($ticket->responses as $response)
                    <div class="message {{ $response->isStaff() ? 'staff' : '' }}" data-response-id="{{ $response->id }}">
                        @if(!$response->isStaff())
                        <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="message-avatar">
                        @endif
                        
                        <div class="message-bubble {{ $response->isStaff() ? 'staff-bubble' : 'customer-bubble' }}">
                            <div class="message-meta">
                                <span class="message-sender">
                                    {{ $response->user->name }}
                                    @if($response->isStaff())
                                    <span class="staff-badge">Nhân viên</span>
                                    @endif
                                </span>
                                <span class="message-timestamp">{{ $response->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="message-content">
                                {!! nl2br(e($response->content)) !!}
                            </div>
                            @if($response->created_at->diffInMinutes(now()) < 60)
                            <div class="message-time">
                                {{ $response->created_at->diffForHumans() }}
                            </div>
                            @endif
                        </div>
                        
                        @if($response->isStaff())
                        <img src="{{ $response->user->getAvatarUrl() }}" alt="Avatar" class="message-avatar">
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Typing indicator -->
                <div class="typing-indicator" id="typing-indicator">
                    <div class="typing-bubble">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            
            <!-- Input form -->
            @if($ticket->status != 'Đã giải quyết' && $ticket->status != 'Đã huỷ')
            <div class="chat-footer">
                <form id="response-form" action="{{ route('customer.support.respond', $ticket->id) }}" method="POST" class="w-full flex items-center relative">
                    @csrf
                    <textarea id="response" name="response" class="chat-input" 
                            placeholder="Nhập tin nhắn của bạn..." rows="1"
                            @error('response') class="border-red-500" @enderror></textarea>
                    <button type="button" id="emoji-button" class="emoji-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button type="submit" class="send-button">
                        <span>Gửi</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
                
                <!-- Emoji picker container -->
                <div id="emoji-picker" class="hidden bg-white rounded-lg shadow-lg p-2 absolute bottom-16 right-16 z-10 border border-gray-200">
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
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        
        // Tự động mở rộng textarea khi nhập nhiều dòng
        const textarea = document.getElementById('response');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                if (this.scrollHeight > 100) {
                    this.style.height = '100px';
                }
            });
        }
        
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
                let emojiHTML = '<div class="grid grid-cols-5 gap-1">';
                commonEmojis.forEach(emoji => {
                    emojiHTML += `<button type="button" class="emoji p-2 hover:bg-gray-100 rounded">${emoji}</button>`;
                });
                emojiHTML += '</div>';
                emojiPicker.innerHTML = emojiHTML;
                
                // Toggle emoji picker
                emojiButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    emojiPicker.classList.toggle('hidden');
                });
                
                // Insert emoji on click
                emojiPicker.querySelectorAll('.emoji').forEach(emoji => {
                    emoji.addEventListener('click', function(e) {
                        e.preventDefault();
                        const cursorPos = textArea.selectionStart;
                        const text = textArea.value;
                        const newText = text.slice(0, cursorPos) + this.textContent + text.slice(cursorPos);
                        textArea.value = newText;
                        textArea.focus();
                        // Trigger input event to resize textarea
                        const event = new Event('input', { bubbles: true });
                        textArea.dispatchEvent(event);
                        emojiPicker.classList.add('hidden');
                    });
                });
                
                // Close emoji picker when clicking outside
                document.addEventListener('click', function(e) {
                    if (!emojiButton.contains(e.target) && !emojiPicker.contains(e.target)) {
                        emojiPicker.classList.add('hidden');
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
                document.getElementById('typing-indicator').style.display = 'block';
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
                        document.getElementById('response').style.height = 'auto';
                        
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
        typingIndicator.style.display = 'block';
        
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
        responseDiv.className = `message ${response.is_staff ? 'staff' : ''}`;
        responseDiv.dataset.responseId = response.id;
        
        let template = '';
        
        if (!response.is_staff) {
            template += `
                <img src="${response.user_avatar}" alt="Avatar" class="message-avatar">
            `;
        }
        
        template += `
            <div class="message-bubble ${response.is_staff ? 'staff-bubble' : 'customer-bubble'}">
                <div class="message-meta">
                    <span class="message-sender">
                        ${response.user_name}
                        ${response.is_staff ? '<span class="staff-badge">Nhân viên</span>' : ''}
                    </span>
                    <span class="message-timestamp">${response.created_at}</span>
                </div>
                <div class="message-content">
                    ${response.content.replace(/\n/g, '<br>')}
                </div>
                <div class="message-time">Vừa xong</div>
            </div>
        `;
        
        if (response.is_staff) {
            template += `
                <img src="${response.user_avatar}" alt="Avatar" class="message-avatar">
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