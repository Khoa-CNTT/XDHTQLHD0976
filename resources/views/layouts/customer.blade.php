<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dịch Vụ Công Nghệ Thông Tin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        /* Đảm bảo những phần tử dropdown menu luôn hiển thị đè lên các phần tử khác */
        #user-dropdown, #guest-dropdown, #notifications-dropdown, #search-dropdown {
            z-index: 50 !important;
        }
        
        /* Đảm bảo các liên kết có thể nhấn được */
        #user-dropdown a, #guest-dropdown a, #notifications-dropdown a, #search-dropdown a {
            position: relative;
            z-index: 60;
        }
        
        /* Cải thiện hiển thị banner để không che phủ menu */
        .banner-container {
            position: relative;
            z-index: 10;
        }
        
        /* Đảm bảo thanh tiêu đề luôn hiển thị đè lên các phần tử khác */
        header {
            position: relative;
            z-index: 40;
        }
    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('status') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#111827',
            iconColor: '#22c55e',  
            customClass: {
                popup: 'rounded-md shadow-md px-4 py-2 text-sm'  
            }
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#111827',
            iconColor: '#ef4444',  
            customClass: {
                popup: 'rounded-md shadow-md px-4 py-2 text-sm'  
            }
        });
    });
</script>
@endif
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-blue-600 text-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex flex-wrap justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="logo">
                    <a href="{{ route('customer.dashboard') }}">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-16 md:h-20 max-w-full">
                    </a>
                </div>
                <h1 class="text-lg md:text-2xl font-bold">Dịch Vụ Công Nghệ Thông Tin</h1>
            </div>
            <nav class="flex flex-wrap items-center space-x-4 mt-4 md:mt-0">
                <ul class="flex flex-wrap space-x-4">
                    <li><a href="{{ route('customer.dashboard') }}" class="hover:text-blue-200 text-sm md:text-base">Trang Chủ</a></li>
                    <li><a href="{{ route('customer.services.index') }}" class="hover:text-blue-200 text-sm md:text-base">Dịch Vụ</a></li>
                    <li><a href="#" class="hover:text-blue-200 text-sm md:text-base">Về Chúng Tôi</a></li>
                    <li><a href="#" class="hover:text-blue-200 text-sm md:text-base">Liên Hệ</a></li>
                </ul>
                
             
                
                @if(auth()->check())
                    <div class="relative mt-4 md:mt-0 mr-4">
                        <button id="notifications-menu-button" class="flex items-center focus:outline-none relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @php
                                $unreadNotificationsCount = auth()->user()->notifications()->where('is_read', false)->get()->unique('id')->count();
                            @endphp
                            @if($unreadNotificationsCount > 0)
                                <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full h-4 w-4 flex items-center justify-center">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @else
                                <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full h-4 w-4 flex items-center justify-center hidden"></span>
                            @endif
                        </button>
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-10 max-h-96 overflow-y-auto">
                            <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                                <span class="font-medium text-gray-800">Thông báo</span>
                                @if($unreadNotificationsCount > 0)
                                    <form action="{{ route('customer.notifications.markAllAsRead') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 bg-transparent border-0 p-0">
                                            Đánh dấu tất cả đã đọc
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div id="notifications-list">
                                <div class="px-4 py-6 text-center text-gray-500">
                                    <p>Đang tải thông báo...</p>
                                </div>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-200">
                                <a href="{{ route('customer.notifications.index') }}" class="block text-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Xem tất cả thông báo
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="relative mt-4 md:mt-0">
                        <button id="user-menu-button" class="flex items-center focus:outline-none">
                            <img src="{{ asset('images/user.png') }}" alt="Ảnh đại diện" class="rounded-full w-8 h-8 md:w-10 md:h-10 mr-2">
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <div class="py-1">
                                <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Thông tin cá nhân
                                </a>
                                
                                <a href="{{ route('customer.contracts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-contract mr-2"></i> Hợp đồng của tôi
                                </a>
                                
                                <a href="{{ route('customer.payments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-credit-card mr-2"></i> Lịch sử thanh toán
                                </a>

                                <a href="{{ route('customer.support.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 relative z-50">
                                    <i class="fas fa-headset mr-2"></i> Yêu cầu hỗ trợ
                                </a>
                                
                                <hr class="my-1 border-gray-200">
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="relative mt-4 md:mt-0">
                        <button id="guest-menu-button" class="px-3 py-2 rounded-full bg-blue-500 text-sm md:text-base text-white hover:bg-blue-600 transition">
                            Đăng nhập
                        </button>
                        <div id="guest-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                            <ul class="py-1">
                                <li>
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Đăng Nhập
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Đăng Ký
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </nav>
        </div>
    </header>
        <!-- Sidebar và Nội Dung -->
        <div class="flex">
        <main class="container mx-auto px-4 py-6">
            @yield('content') 
        </main>
        </div>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Về Chúng Tôi</h3>
                    <p class="text-gray-400 text-sm md:text-base">Chúng tôi cung cấp các giải pháp công nghệ thông tin hiện đại, giúp doanh nghiệp của bạn phát triển mạnh mẽ.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Liên Kết Nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('customer.dashboard') }}" class="hover:underline text-sm md:text-base">Trang Chủ</a></li>
                        <li><a href="{{ route('customer.contracts.index') }}" class="hover:underline text-sm md:text-base">Hợp Đồng</a></li>
                        <li><a href="#" class="hover:underline text-sm md:text-base">Dịch Vụ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Liên Hệ</h3>
                    <p class="text-gray-400 text-sm md:text-base">Email: okamibada@gmail.com</p>
                    <p class="text-gray-400 text-sm md:text-base">Hotline: 0987-653-214</p>
                </div>
            </div>
            <div class="mt-6 text-gray-400 text-sm md:text-base">
                &copy; Dịch Vụ Công Nghệ Thông Tin. Bảo lưu mọi quyền.
            </div>
        </div>
    </footer>
   
<script>
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    const guestMenuButton = document.getElementById('guest-menu-button');
    const guestDropdown = document.getElementById('guest-dropdown');
    const notificationsButton = document.getElementById('notifications-menu-button');
    const notificationsDropdown = document.getElementById('notifications-dropdown');

    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
            if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        });
    }

    if (guestMenuButton && guestDropdown) {
        guestMenuButton.addEventListener('click', () => {
            guestDropdown.classList.toggle('hidden');
        });
    }
    
    if (notificationsButton && notificationsDropdown) {
        notificationsButton.addEventListener('click', () => {
            notificationsDropdown.classList.toggle('hidden');
            if (userDropdown) userDropdown.classList.add('hidden');
            if (searchDropdown) searchDropdown.classList.add('hidden');
        });
    }

    // Search dropdown functionality
    const searchButton = document.getElementById('search-button');
    const searchDropdown = document.getElementById('search-dropdown');
    
    if (searchButton && searchDropdown) {
        searchButton.addEventListener('click', () => {
            searchDropdown.classList.toggle('hidden');
            if (userDropdown) userDropdown.classList.add('hidden');
            if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        });
    }

    // Cải thiện xử lý sự kiện click outside để đóng dropdown
    document.addEventListener('click', (event) => {
        // Đóng user dropdown khi click bên ngoài
        if (userDropdown && userMenuButton && !userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
        
        // Đóng guest dropdown khi click bên ngoài
        if (guestDropdown && guestMenuButton && !guestMenuButton.contains(event.target) && !guestDropdown.contains(event.target)) {
            guestDropdown.classList.add('hidden');
        }
        
        // Đóng notifications dropdown khi click bên ngoài
        if (notificationsDropdown && notificationsButton && !notificationsButton.contains(event.target) && !notificationsDropdown.contains(event.target)) {
            notificationsDropdown.classList.add('hidden');
        }
        
        // Đóng search dropdown khi click bên ngoài
        if (searchDropdown && searchButton && !searchButton.contains(event.target) && !searchDropdown.contains(event.target)) {
            searchDropdown.classList.add('hidden');
        }
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        // Hàm cập nhật thông báo
        function checkNewNotifications() {
            fetch('/customer/api/notifications/check', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                // Cập nhật số lượng thông báo chưa đọc
                const unreadCount = data.unreadCount;
                const unreadBadge = document.querySelector('#notification-badge');
                
                if (unreadBadge) {
                    if (unreadCount > 0) {
                        unreadBadge.textContent = unreadCount;
                        unreadBadge.classList.remove('hidden');
                    } else {
                        unreadBadge.classList.add('hidden');
                    }
                }
                
                // Cập nhật danh sách thông báo nếu có mới
                if (data.hasNewNotifications) {
                    // Hiển thị thông báo toast cho người dùng
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Bạn có thông báo mới!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    
                    // Tự động cập nhật nội dung thông báo
                    updateNotificationsList();
                }
            })
            .catch(error => console.error('Lỗi kiểm tra thông báo:', error));
        }
        
        // Biến để theo dõi ID của các thông báo đã hiển thị
        let displayedNotificationIds = new Set();
        
        // Hàm cập nhật danh sách thông báo
        function updateNotificationsList() {
            fetch('/customer/api/notifications/latest')
                .then(response => response.json())
                .then(data => {
                    const notificationsList = document.querySelector('#notifications-list');
                    if (notificationsList && data.notifications.length > 0) {
                        // Tạo Map từ ID thông báo để loại bỏ trùng lặp
                        const notificationsMap = new Map();
                        
                        // Chỉ xử lý các thông báo chưa hiển thị
                        data.notifications.forEach(notification => {
                            if (!displayedNotificationIds.has(notification.id)) {
                                notificationsMap.set(notification.id, notification);
                                // Đánh dấu đã hiển thị
                                displayedNotificationIds.add(notification.id);
                            }
                        });
                        
                        // Giới hạn kích thước Set để tránh tràn bộ nhớ
                        if (displayedNotificationIds.size > 50) {
                            // Giữ lại 30 ID mới nhất
                            displayedNotificationIds = new Set(
                                Array.from(displayedNotificationIds).slice(-30)
                            );
                        }
                        
                        // Chuyển lại thành mảng
                        const uniqueNotifications = Array.from(notificationsMap.values());
                        
                        // Cập nhật danh sách thông báo
                        let notificationsHtml = '';
                        
                        // Kết hợp thông báo mới với thông báo hiện tại
                        if (uniqueNotifications.length > 0) {
                            // Lấy nội dung HTML hiện tại
                            const currentHtml = notificationsList.innerHTML;
                            
                            // Thêm thông báo mới vào đầu
                            uniqueNotifications.forEach(notification => {
                                notificationsHtml += `
                                <a href="/customer/notifications/${notification.id}" class="block px-4 py-3 border-b hover:bg-gray-50 ${notification.is_read ? 'bg-white' : 'bg-blue-50'}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                                            <p class="text-xs text-gray-500 line-clamp-2">${notification.message}</p>
                                            <p class="text-xs text-gray-400 mt-1">${notification.time_ago}</p>
                                        </div>
                                    </div>
                                </a>
                                `;
                            });
                            
                            // Nếu là lần đầu tiên tải, thay thế hoàn toàn
                            if (currentHtml.includes('Đang tải thông báo...')) {
                                notificationsList.innerHTML = notificationsHtml;
                            } else {
                                // Nếu đã có nội dung, chỉ cập nhật nếu có thông báo mới
                                if (notificationsHtml) {
                                    notificationsList.innerHTML = notificationsHtml + currentHtml;
                                    
                                    // Giới hạn số lượng thông báo hiển thị để tránh quá dài
                                    const notificationItems = notificationsList.querySelectorAll('a');
                                    if (notificationItems.length > 5) {
                                        // Chỉ giữ lại 5 thông báo đầu tiên
                                        for (let i = 5; i < notificationItems.length; i++) {
                                            notificationItems[i].remove();
                                        }
                                    }
                                }
                            }
                        } else if (notificationsList.innerHTML.includes('Đang tải thông báo...')) {
                            // Nếu không có thông báo nào và đang hiển thị "Đang tải..."
                            notificationsList.innerHTML = `
                            <div class="px-4 py-6 text-center text-gray-500">
                                <p>Không có thông báo nào</p>
                            </div>
                            `;
                        }
                    }
                })
                .catch(error => console.error('Lỗi tải thông báo mới:', error));
        }
        
        // Kiểm tra thông báo khi trang tải xong và sau mỗi 30 giây
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm thẻ meta CSRF
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const metaTag = document.createElement('meta');
                metaTag.setAttribute('name', 'csrf-token');
                metaTag.setAttribute('content', '{{ csrf_token() }}');
                document.head.appendChild(metaTag);
            }
            
            // Tải danh sách thông báo ngay khi trang tải xong
            updateNotificationsList();
            
            // Kiểm tra thông báo mới sau 5 giây đầu tiên
            setTimeout(checkNewNotifications, 5000);
            
            // Kiểm tra thông báo mỗi 30 giây
            setInterval(checkNewNotifications, 30000);
            
            // Thêm sự kiện click vào nút thông báo
            const notificationsButton = document.getElementById('notifications-menu-button');
            if (notificationsButton) {
                notificationsButton.addEventListener('click', function() {
                    // Cập nhật danh sách thông báo mỗi khi click vào nút
                    updateNotificationsList();
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>