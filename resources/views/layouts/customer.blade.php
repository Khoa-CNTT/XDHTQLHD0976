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
        
        /* Style cho dropdown thông báo */
        #notifications-dropdown {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(209, 213, 219, 1);
        }
        
        #notifications-dropdown .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        #notifications-dropdown .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        
        #notifications-list a:last-child {
            border-bottom: none;
        }
        
        #notification-badge {
            font-size: 0.75rem;
            font-weight: bold;
            min-width: 1rem;
            min-height: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px #2563eb;
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
                            @endif
                        </button>
                       <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
    <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center bg-blue-50">
        <span class="font-bold text-gray-800">Thông báo</span>
        @if($unreadNotificationsCount > 0)
            <form action="{{ route('customer.notifications.markAllAsRead') }}" method="POST" class="inline" id="mark-all-read-form">
                @csrf
                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 bg-transparent border-0 p-0 font-medium">
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
    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
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
    @php
        $supportNotificationsCount = auth()->user()->notifications()
            ->where('type', 'support')
        ->where('is_read', false)
        ->count();
    @endphp
    @if($supportNotificationsCount > 0)
        <span class="absolute top-0 right-0 bg-red-500 text-xs text-white rounded-full h-4 w-4 flex items-center justify-center">
            {{ $supportNotificationsCount }}
        </span>
    @endif
</a>
                                
                                <hr class="my-1 border-gray-200">
                                
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                    </button>
                                </form>
                                <script>
                                    // Xóa tất cả dữ liệu chữ ký khi đăng xuất
                                    document.getElementById('logout-form').addEventListener('submit', function() {
                                        // Xóa tất cả các key bắt đầu bằng 'savedSignature_'
                                        for (let i = 0; i < localStorage.length; i++) {
                                            const key = localStorage.key(i);
                                            if (key && key.startsWith('savedSignature_')) {
                                                localStorage.removeItem(key);
                                            }
                                        }
                                    });
                                </script>
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
                        <li><a href="{{ route('customer.services.index') }}" class="hover:underline text-sm md:text-base">Dịch Vụ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Liên Hệ</h3>
                    <p class="text-gray-400 text-sm md:text-base">Email: okamibada@gmail.com</p>
                    <p class="text-gray-400 text-sm md:text-base">Hotline: 0987-653-214</p>
                    <p class="text-gray-400 text-sm md:text-base">123 Đường Nguyễn Văn Linh, Hải Châu, TP. Đà Nẵng</p>
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
            if (typeof searchDropdown !== 'undefined' && searchDropdown) searchDropdown.classList.add('hidden');
            
            // Cập nhật danh sách thông báo khi mở dropdown
            updateNotificationsList();
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

    // Mark all as read form handling
    const markAllReadForm = document.getElementById('mark-all-read-form');
    if (markAllReadForm) {
        markAllReadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Perform AJAX form submission
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams(new FormData(this))
            })
            .then(response => response.json())
            .then(data => {
                // Show success message
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Tất cả thông báo đã được đánh dấu là đã đọc.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Update UI
                const unreadBadge = document.querySelector('#notification-badge');
                if (unreadBadge) {
                    unreadBadge.style.display = 'none';
                }
                
             
                const notificationItems = document.querySelectorAll('#notifications-list a');
                notificationItems.forEach(item => {
                    item.classList.remove('bg-blue-50');
                    item.classList.add('bg-white');
                });
              
                markAllReadForm.style.display = 'none';
                
                
                fetch('/customer/api/notifications/check', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(checkData => {
                    console.log('Notification data updated:', checkData);
                    // Kết quả cập nhật thông báo
                    localStorage.setItem('lastNotificationUpdate', new Date().getTime());
                })
                .catch(error => console.error('Lỗi cập nhật dữ liệu thông báo:', error));
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Có lỗi xảy ra khi đánh dấu đã đọc.',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        });
    }
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
                
                if (unreadCount > 0) {
                    // Tạo badge nếu không tồn tại
                    if (!unreadBadge) {
                        const newBadge = document.createElement('span');
                        newBadge.id = 'notification-badge';
                        newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full h-4 w-4 flex items-center justify-center';
                        newBadge.textContent = unreadCount;
                        document.getElementById('notifications-menu-button').appendChild(newBadge);
                    } else {
                        // Cập nhật badge hiện tại
                        unreadBadge.textContent = unreadCount;
                        unreadBadge.style.display = '';
                    }
                } else if (unreadBadge) {
                    // Ẩn badge khi không có thông báo
                    unreadBadge.style.display = 'none';
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
        
        // Hàm cập nhật danh sách thông báo
        function updateNotificationsList() {
            const notificationsList = document.getElementById('notifications-list');
            if (notificationsList) {
                notificationsList.innerHTML = '<div class="px-4 py-6 text-center text-gray-500"><p>Đang tải thông báo...</p></div>';
                
                fetch('/customer/api/notifications/latest')
                    .then(response => response.json())
                    .then(data => {
                        if (data.notifications && data.notifications.length > 0) {
                            let notificationsHtml = '';
                            const notificationsToShow = data.notifications.slice(0, 3); // Chỉ hiển thị 3 thông báo
                            
                            notificationsToShow.forEach(notification => {
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
                            
                            notificationsList.innerHTML = notificationsHtml;
                        } else {
                            notificationsList.innerHTML = `
                            <div class="px-4 py-6 text-center text-gray-500">
                                <p>Không có thông báo nào</p>
                            </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi tải thông báo:', error);
                        notificationsList.innerHTML = `
                        <div class="px-4 py-6 text-center text-gray-500">
                            <p>Có lỗi xảy ra khi tải thông báo</p>
                        </div>
                        `;
                    });
            }
        }
        
        // Tải danh sách thông báo và thiết lập cập nhật tự động
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm thẻ meta CSRF nếu cần
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const metaTag = document.createElement('meta');
                metaTag.setAttribute('name', 'csrf-token');
                metaTag.setAttribute('content', '{{ csrf_token() }}');
                document.head.appendChild(metaTag);
            }
            
            // Kiểm tra cập nhật thông báo từ lần trước
            const lastUpdate = localStorage.getItem('lastNotificationUpdate');
            const checkInterval = 5000; // 5 giây

            if (!lastUpdate || (new Date().getTime() - parseInt(lastUpdate)) > checkInterval) {
                // Lấy thông tin cập nhật từ server
                checkNewNotifications();
                localStorage.setItem('lastNotificationUpdate', new Date().getTime());
            }
            
            // Tải danh sách thông báo ngay khi trang tải xong
            updateNotificationsList();
            
            // Kiểm tra thông báo mới mỗi 30 giây
            setInterval(checkNewNotifications, 30000);
            
            // Khởi tạo AOS (Animate on Scroll)
            AOS.init({
                duration: 800,
                once: true
            });
        });












    // Đăng ký Service Worker
    // Kiểm tra xem trình duyệt hỗ trợ Service Worker
         if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((registration) => {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch((error) => {
                    console.error('Service Worker registration failed:', error);
                });
        });
    }
    </script>
    
    @stack('scripts')
</body>
</html>