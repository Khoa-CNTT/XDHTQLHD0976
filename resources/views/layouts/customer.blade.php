<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dịch Vụ Công Nghệ Thông Tin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    
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
                </ul>
                @if(auth()->check())
                    <div class="relative mt-4 md:mt-0 mr-4">
                        <button id="notifications-menu-button" class="flex items-center focus:outline-none relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full h-4 w-4 flex items-center justify-center">
                                    {{ auth()->user()->unreadNotifications()->count() }}
                                </span>
                            @endif
                        </button>
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-10 max-h-96 overflow-y-auto">
                            <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                                <span class="font-medium text-gray-800">Thông báo</span>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <a href="{{ route('customer.notifications.markAllAsRead') }}" class="text-xs text-blue-600 hover:text-blue-800">
                                        Đánh dấu tất cả đã đọc
                                    </a>
                                @endif
                            </div>
                            <div>
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    <a href="{{ route('customer.notifications.show', $notification->id) }}" class="block px-4 py-3 border-b hover:bg-gray-50 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-2">{{ $notification->message }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-gray-500">
                                        <p>Không có thông báo nào</p>
                                    </div>
                                @endforelse
                                
                                @if(auth()->user()->notifications()->count() > 5)
                                    <div class="px-4 py-2 text-center">
                                        <a href="{{ route('customer.profile') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            Xem tất cả thông báo
                                        </a>
                                    </div>
                                @endif
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
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                            <div class="px-4 py-3 border-b">
                                <span class="block text-sm text-gray-900">{{ auth()->user()->name }}</span>
                                <span class="block text-sm text-gray-500 truncate">{{ auth()->user()->email }}</span>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Trang Cá Nhân
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.contracts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Hợp Đồng Của Tôi
                                    </a>
                                </li>
                                <li>
                                <a href="{{ route('customer.payments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Lịch sử thanh toán
                                </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @csrf
                                        <button type="submit" class="w-full text-left text-red-600">Đăng Xuất</button>
                                    </form>
                                </li>
                            </ul>
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
        });
    }

    document.addEventListener('click', (event) => {
        if (userDropdown && !userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
        if (guestDropdown && !guestMenuButton.contains(event.target) && !guestDropdown.contains(event.target)) {
            guestDropdown.classList.add('hidden');
        }
        if (notificationsDropdown && !notificationsButton.contains(event.target) && !notificationsDropdown.contains(event.target)) {
            notificationsDropdown.classList.add('hidden');
        }
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</body>
</html>