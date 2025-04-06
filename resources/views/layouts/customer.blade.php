<!-- filepath: c:\Users\ASUS_TUF\Documents\QuanLyHopDong\ConT_management\resources\views\layouts\customer.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dịch Vụ Công Nghệ Thông Tin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-blue-600 text-white py-6 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="/api/placeholder/50/50" alt="Logo" class="h-12 w-12 mr-4">
                <h1 class="text-2xl font-bold">Dịch Vụ Công Nghệ Thông Tin</h1>
            </div>
            <nav class="flex items-center space-x-6">
                <ul class="flex space-x-6 mr-4">
                    <li><a href="{{ route('customer.dashboard') }}" class="hover:text-blue-200">Trang Chủ</a></li>
                    <li><a href="{{ route('customer.contracts.index') }}" class="hover:text-blue-200">Hợp Đồng</a></li>
                    <li><a href="#" class="hover:text-blue-200">Dịch Vụ</a></li>
                </ul>
                
                <!-- Dropdown Trang Cá Nhân -->
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center focus:outline-none">
                        <img src="/api/placeholder/40/40" alt="Ảnh đại diện" class="rounded-full w-10 h-10 mr-2">
                        <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-10">
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
                                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full text-left">Đăng Xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Sidebar và Nội Dung -->
    <div class="flex">
       

        <!-- Main Content -->
        <main class="flex-1 bg-white p-6">
            @yield('content')
        </main>
    </div>

     <!-- Footer -->
     <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Cột 1 -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Về Chúng Tôi</h3>
                    <p class="text-gray-400">Chúng tôi cung cấp các giải pháp công nghệ thông tin hiện đại, giúp doanh nghiệp của bạn phát triển mạnh mẽ.</p>
                </div>
                <!-- Cột 2 -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Liên Kết Nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('customer.dashboard') }}" class="hover:underline">Trang Chủ</a></li>
                        <li><a href="{{ route('customer.contracts.index') }}" class="hover:underline">Hợp Đồng</a></li>
                        <li><a href="#" class="hover:underline">Dịch Vụ</a></li>
                    </ul>
                </div>
                <!-- Cột 3 -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Liên Hệ</h3>
                    <p class="text-gray-400">Email: support@congnghe.com</p>
                    <p class="text-gray-400">Hotline: 0123-456-789</p>
                </div>
            </div>
            <div class="mt-6 text-gray-400">
                &copy; 2025 Dịch Vụ Công Nghệ Thông Tin. Bảo lưu mọi quyền.
            </div>
        </div>
    </footer>

    <script>
        // Xử lý dropdown menu trang cá nhân
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Đóng dropdown khi click ngoài
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>