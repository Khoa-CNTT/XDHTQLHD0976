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
            <main class="flex-1 bg-white p-6">
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

    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
    }

    if (guestMenuButton && guestDropdown) {
        guestMenuButton.addEventListener('click', () => {
            guestDropdown.classList.toggle('hidden');
        });
    }

    document.addEventListener('click', (event) => {
        if (userDropdown && !userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
        if (guestDropdown && !guestMenuButton.contains(event.target) && !guestDropdown.contains(event.target)) {
            guestDropdown.classList.add('hidden');
        }
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</body>
</html>