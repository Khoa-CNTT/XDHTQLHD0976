@extends('layouts.customer')

@section('title', 'Trang Chủ ')

@section('content')

<div class="container mx-auto">
    {{-- Thanh hình ảnh chạy - sử dụng Alpine.js --}}
    <section 
        x-data="{
                images: [
                
                '/banners/bbb.png',
                '/banners/bbb1.png',
                '/banners/bbb2.png',
                '/banners/bbb3.png',
        
       
                ],
                currentIndex: 0,
                next() { this.currentIndex = (this.currentIndex + 1) % this.images.length },
                prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length },
                startSlider() { setInterval(() => this.next(), 5000); }
            }"
        x-init="startSlider"
        class="relative overflow-hidden rounded-xl shadow-lg h-[300px]"
        >

        <!-- Khung ảnh -->
        <div 
            class="flex h-full transition-transform duration-[1200ms] ease-[cubic-bezier(0.65,0,0.35,1)]"
            :style="{ transform: 'translateX(-' + currentIndex * 100 + '%)' }" >
            <template x-for="(image, index) in images" :key="index">
                <div class="w-full flex-shrink-0 h-full">
                    <img :src="image" class="w-full h-full object-cover" />
                </div>
            </template>
        </div>

        <!-- Button trái -->
        <button @click="prev"
            class="absolute left-3 top-1/2 transform -translate-y-1/2 
                w-9 h-9 flex items-center justify-center 
                rounded-full border border-white/50 
                bg-white/10 text-white hover:bg-white/20 
                transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Button phải -->
        <button @click="next"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 
                w-9 h-9 flex items-center justify-center 
                rounded-full border border-white/50 
                bg-white/10 text-white hover:bg-white/20 
                transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </section>

    <!-- Danh mục và Tìm kiếm -->
    <div class="bg-white shadow-sm mt-5 border border-gray-200 rounded-2xl px-1 py-2">
        <div class="container mx-auto px-4 py-3 flex gap-x-10 items-center">
            <form action="{{ route('customer.services.search') }}" method="GET" class="relative w-1/3 mr-6">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Tìm kiếm dịch vụ..." 
                    value="{{ request('query') }}" 
                    class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                </svg>
            </form>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('customer.services.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Tất Cả Dịch Vụ</a></li>
                    @foreach (\App\Models\ServiceCategory::has('services')->get() as $category)
                        <li>
                            <a href="{{ route('customer.services.filterByCategory', $category->id) }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    <!-- Khu vực mới: Tin tức, cập nhật và đề xuất cá nhân hóa -->
    <div class="grid md:grid-cols-2 gap-6 mt-6">
        <!-- Tin tức và cập nhật -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden" data-aos="fade-up">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Tin tức & Cập nhật mới nhất
                </h2>
            </div>
            
            <div class="p-6">
                <!-- Dịch vụ mới -->
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <div class="flex items-center mb-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded mr-2">MỚI</span>
                        <h3 class="text-lg font-semibold text-gray-800">Dịch vụ quản lý tài liệu trên cloud</h3>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Lưu trữ, quản lý và đồng bộ hóa tài liệu của bạn với dịch vụ cloud mới nhất từ chúng tôi. An toàn, bảo mật và hiệu quả.</p>
                    <div class="flex items-center text-sm text-blue-600">
                        <span>Khám phá ngay</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
                
                <!-- Cập nhật hệ thống -->
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <div class="flex items-center mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded mr-2">CẬP NHẬT</span>
                        <h3 class="text-lg font-semibold text-gray-800">Bảo trì hệ thống định kỳ</h3>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Hệ thống sẽ được bảo trì vào ngày 15/05/2025 từ 23:00 đến 01:00 sáng hôm sau. Xin lỗi vì sự bất tiện này.</p>
                    <div class="flex items-center text-sm text-blue-600">
                        <span>Xem chi tiết</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
                
                <!-- Blog và nội dung hữu ích -->
                <div class="mb-1">
                    <div class="flex items-center mb-2">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded mr-2">BÀI VIẾT</span>
                        <h3 class="text-lg font-semibold text-gray-800">5 cách bảo vệ dữ liệu doanh nghiệp</h3>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">Tìm hiểu các phương pháp hiệu quả để bảo vệ dữ liệu quan trọng của doanh nghiệp bạn khỏi các mối đe dọa mạng.</p>
                    <div class="flex items-center text-sm text-blue-600">
                        <span>Đọc ngay</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-3 text-center">
                <a href="#" class="text-blue-600 font-medium hover:text-blue-800 transition flex items-center justify-center">
                    <span>Xem tất cả thông báo</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Đề xuất cá nhân hóa -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Đề xuất dành cho bạn
                </h2>
            </div>
            
            <div class="p-6">
                <!-- Dịch vụ phổ biến -->
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-red-100 p-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800">Dịch vụ phổ biến</h3>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-blue-50 transition cursor-pointer group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-800">Website Doanh Nghiệp Pro</h4>
                                    <p class="text-sm text-gray-500">Dịch vụ thiết kế website phổ biến nhất của chúng tôi</p>
                                </div>
                            </div>
                            <span class="text-blue-600 opacity-0 group-hover:opacity-100 transition">Xem</span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-blue-50 transition cursor-pointer group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-800">Email Marketing Plus</h4>
                                    <p class="text-sm text-gray-500">Tiếp cận khách hàng hiệu quả với email marketing</p>
                                </div>
                            </div>
                            <span class="text-blue-600 opacity-0 group-hover:opacity-100 transition">Xem</span>
                        </div>
                    </div>
                </div>
                
                <!-- Đề xuất riêng -->
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <div class="flex items-center mb-3">
                        <div class="bg-indigo-100 p-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800">Phù hợp với bạn</h3>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg hover:bg-blue-50 transition cursor-pointer group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-medium text-gray-800">Ứng dụng di động</h4>
                                    <p class="text-sm text-gray-500">Bổ sung ứng dụng di động cho website hiện tại</p>
                                </div>
                            </div>
                            <span class="text-blue-600 opacity-0 group-hover:opacity-100 transition">Xem</span>
                        </div>
                    </div>
                </div>
                
                <!-- Combo tiết kiệm -->
                <div class="mb-1">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 p-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-800">Combo tiết kiệm</h3>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 p-4 rounded-lg border border-green-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0">
                            <div class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg shadow-md transform rotate-12 translate-x-2 -translate-y-1">
                                TIẾT KIỆM 25%
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Gói Doanh Nghiệp Toàn Diện</h4>
                        <p class="text-sm text-gray-600 mb-3">Kết hợp website, hosting và email doanh nghiệp với giá ưu đãi đặc biệt.</p>
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-bold text-green-600">
                                4.500.000đ
                                <span class="text-sm text-gray-500 line-through ml-2">6.000.000đ</span>
                            </div>
                            <button class="px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition">
                                Xem chi tiết
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-3 text-center">
                <a href="{{ route('customer.services.index') }}" class="text-blue-600 font-medium hover:text-blue-800 transition flex items-center justify-center">
                    <span>Xem tất cả đề xuất</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Dịch Vụ Nổi Bật với container riêng -->
    <section class="py-16 bg-white my-12 rounded-xl shadow-md">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Dịch Vụ Nổi Bật</h2>
                <div class="w-24 h-1.5 bg-blue-600 mx-auto mb-6 rounded-full"></div>
                <p class="text-gray-600 max-w-3xl mx-auto">
                    Khám phá các dịch vụ chất lượng cao từ chúng tôi, được thiết kế đặc biệt để đáp ứng mọi nhu cầu của doanh nghiệp bạn.
                </p>
            </div>

    {{-- Danh sách hợp đồng dịch vụ --}}
            <div class="grid md:grid-cols-3 gap-6">
        @forelse($services as $service)
                <div class="flex flex-col justify-between bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-2 relative">
            
            <!-- Nhãn "Mới" (Bao phủ góc trên trái) -->
            @if($service->created_at && $service->created_at->gt(now()->subDays(3)) && !$service->is_hot)
            <span class="absolute top-0 left-0 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-br-full">
                Mới
            </span>
            @endif

            <!-- Nhãn "Hot" (Bao phủ góc trên phải) -->
            @if($service->is_hot)
                <span class="absolute top-0 right-0 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-bl-full">
                    Hot
                </span>
            @endif

        
            <!-- Nội dung dịch vụ -->
            <div>
                <div class="w-100 h-64 overflow-hidden rounded-lg">
                    <img class="w-full h-full object-cover" src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/default.jpg') }}" 
                    alt="{{ $service->service_name }}" >
                </div>  
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 mt-4">{{ $service->service_name }}</h3>
                <p class="text-gray-600 mb-2 line-clamp-3">{{ $service->description }}</p>
                <p class="text-gray-600 mb-1"><strong>Loại dịch vụ:</strong> {{ $service->category->name ?? 'Không có danh mục' }}</p>
            </div>
            <div>
                <a href="{{ route('customer.services.show', $service->id) }}" 
                   class="text-sm px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition inline-block">
                    Xem Hợp Đồng
                </a>
            </div>
        </div>
        @empty
                <div class="col-span-3 text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-600 text-lg">Chúng tôi rất tiếc, không có dịch vụ nào bạn đang tìm kiếm!</p>
                    <a href="{{ route('customer.services.index') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Xem tất cả dịch vụ
                    </a>
                </div>
        @endforelse
    </div>
    
    
    </section>

   <!-- Hero Section: Thiết kế hiện đại với hiệu ứng lượn sóng -->
   <section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 text-white py-28">
    <!-- Hiệu ứng lượn sóng -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full text-white">
            <path fill="currentColor" fill-opacity="0.3" d="M0,224L60,218.7C120,213,240,203,360,202.7C480,203,600,213,720,229.3C840,245,960,267,1080,266.7C1200,267,1320,245,1380,234.7L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full -mt-36 text-white">
            <path fill="currentColor" fill-opacity="0.6" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,229.3C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full -mt-32 text-white">
            <path fill="currentColor" fill-opacity="1" d="M0,192L48,208C96,224,192,256,288,261.3C384,267,480,245,576,218.7C672,192,768,160,864,165.3C960,171,1056,213,1152,218.7C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
    
    <!-- Nội dung Hero -->
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left mb-10 md:mb-0" data-aos="fade-right" data-aos-delay="200">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Giải Pháp Công Nghệ <span class="text-yellow-300">Tiên Tiến</span> Cho Doanh Nghiệp
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-lg mx-auto md:mx-0">
                    Chúng tôi cung cấp dịch vụ toàn diện, giúp doanh nghiệp chuyển đổi số và phát triển bền vững trong kỷ nguyên công nghệ 4.0.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="{{ route('customer.services.index') }}" class="bg-white text-blue-800 px-8 py-3 rounded-full font-semibold hover:bg-yellow-300 hover:text-blue-900 transition shadow-lg transform hover:-translate-y-1">
                        Khám Phá Dịch Vụ
                    </a>
                    <a href="#lien-he" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-800 transition shadow-lg transform hover:-translate-y-1">
                        Liên Hệ Ngay
                    </a>
                </div>
            </div>
            <div class="md:w-1/2" data-aos="fade-left" data-aos-delay="400">
                <img src="{{ asset('images/hero-image.png') }}" alt="IT Services" class="w-full max-w-md mx-auto drop-shadow-2xl transform hover:scale-105 transition duration-500" onerror="this.src='https://img.freepik.com/free-vector/isometric-technology-abstract-background-with-glowing-elements_52683-25916.jpg?w=826&t=st=1684323578~exp=1684324178~hmac=c0df6c1178d7342e8a91e9b95cc9edc81ce87da09c4b82bd62b7c0ec4d9c6ba1';">
            </div>
        </div>
    </div>

    <!-- Stats Counter -->
    <div class="container mx-auto px-6 relative z-10 mt-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="200">
                <h3 class="text-3xl md:text-4xl font-bold text-yellow-300">100+</h3>
                <p class="text-blue-100">Khách Hàng</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="300">
                <h3 class="text-3xl md:text-4xl font-bold text-yellow-300">200+</h3>
                <p class="text-blue-100">Dự Án</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="400">
                <h3 class="text-3xl md:text-4xl font-bold text-yellow-300">10+</h3>
                <p class="text-blue-100">Năm Kinh Nghiệm</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 transform hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="500">
                <h3 class="text-3xl md:text-4xl font-bold text-yellow-300">95%</h3>
                <p class="text-blue-100">Khách Hàng Hài Lòng</p>
            </div>
        </div>
    </div>
</section>

<!-- Giới thiệu: Thiết kế hiện đại với các thẻ thông tin -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4" data-aos="fade-up">Về Chúng Tôi</h2>
            <div class="w-20 h-1.5 bg-blue-600 mx-auto mb-6 rounded-full" data-aos="fade-up" data-aos-delay="200"></div>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="300">
                Với đội ngũ chuyên gia giàu kinh nghiệm và đam mê công nghệ, chúng tôi tự hào mang đến những giải pháp công nghệ toàn diện, giúp doanh nghiệp tối ưu hóa hoạt động và đạt được những mục tiêu kinh doanh.
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="md:w-5/12" data-aos="fade-right">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" 
                        alt="Đội ngũ công ty" 
                        class="w-full rounded-lg shadow-xl object-cover h-96"
                        onerror="this.src='https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'">
                    <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-blue-600 rounded-lg flex items-center justify-center text-white p-4 shadow-lg" data-aos="zoom-in" data-aos-delay="400">
                        <div class="text-center">
                            <h3 class="text-3xl font-bold">10+</h3>
                            <p class="text-sm">Năm Kinh Nghiệm</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="md:w-7/12 mt-12 md:mt-0" data-aos="fade-left">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Tầm Nhìn & Sứ Mệnh</h3>
                <p class="text-gray-600 mb-6">
                    Tại Công ty chúng tôi, chúng tôi không chỉ cung cấp dịch vụ công nghệ - chúng tôi kiến tạo tương lai kỹ thuật số cho doanh nghiệp của bạn. Sứ mệnh của chúng tôi là đồng hành cùng khách hàng trên hành trình chuyển đổi số và phát triển bền vững.
                </p>
                
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Chất Lượng Hàng Đầu</h4>
                            <p class="text-gray-600 text-sm">Cam kết mang đến dịch vụ hoàn hảo với tiêu chuẩn cao nhất</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Đúng Tiến Độ</h4>
                            <p class="text-gray-600 text-sm">Hoàn thành dự án đúng hạn và tối ưu hóa quy trình</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Tăng Trưởng</h4>
                            <p class="text-gray-600 text-sm">Giúp doanh nghiệp phát triển và mở rộng thị trường</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">An Toàn Dữ Liệu</h4>
                            <p class="text-gray-600 text-sm">Bảo mật thông tin và dữ liệu khách hàng tuyệt đối</p>
                        </div>
                    </div>
                </div>
                
                <a href="#dich-vu" class="inline-flex items-center space-x-2 text-blue-600 font-semibold hover:text-blue-800 transition">
                    <span>Khám phá dịch vụ của chúng tôi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Dịch vụ: Thiết kế hiện đại với icon và hiệu ứng hover -->
<section id="dich-vu" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold uppercase tracking-wider" data-aos="fade-up">Các Dịch Vụ Của Chúng Tôi</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4" data-aos="fade-up" data-aos-delay="200">Giải Pháp Công Nghệ Toàn Diện</h2>
            <div class="w-20 h-1.5 bg-blue-600 mx-auto mb-6 rounded-full" data-aos="fade-up" data-aos-delay="300"></div>
            <p class="text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="400">
                Chúng tôi cung cấp đa dạng dịch vụ công nghệ chất lượng cao, đáp ứng mọi nhu cầu chuyển đổi số cho doanh nghiệp của bạn.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Dịch vụ 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up">
                <div class="p-6 relative">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white rounded-bl-xl px-4 py-1 text-sm font-medium">
                        Phổ biến
                    </div>
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Thiết Kế & Phát Triển Website</h3>
                    <p class="text-gray-600 mb-4">Tạo website đẳng cấp, tương thích đa thiết bị với thiết kế UI/UX hiện đại, tối ưu SEO và tốc độ tải trang.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Website doanh nghiệp chuyên nghiệp
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Website thương mại điện tử
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Landing page & Micro websites
                        </li>
                    </ul>
                    <a href="{{ route('customer.services.index') }}" class="text-blue-600 font-medium hover:text-blue-800 flex items-center group-hover:translate-x-2 transition-transform">
                        Tìm hiểu thêm
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Dịch vụ 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="p-6">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Phát Triển Ứng Dụng Di Động</h3>
                    <p class="text-gray-600 mb-4">Xây dựng ứng dụng di động đa nền tảng với giao diện hiện đại, trải nghiệm người dùng đỉnh cao và tối ưu hiệu suất.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Ứng dụng Android & iOS
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Ứng dụng đa nền tảng (React Native, Flutter)
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Tích hợp API & Dịch vụ đám mây
                        </li>
                    </ul>
                    <a href="{{ route('customer.services.index') }}" class="text-indigo-600 font-medium hover:text-indigo-800 flex items-center group-hover:translate-x-2 transition-transform">
                        Tìm hiểu thêm
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Dịch vụ 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                <div class="p-6">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tư Vấn Chuyển Đổi Số</h3>
                    <p class="text-gray-600 mb-4">Đồng hành cùng doanh nghiệp trong quá trình chuyển đổi số toàn diện, từ chiến lược đến triển khai thực tế.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Tư vấn chiến lược công nghệ
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Quy trình số hóa tài liệu & dữ liệu
                        </li>
                        <li class="flex items-center text-gray-600 text-sm">
                            <svg class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Đào tạo nhân sự chuyển đổi số
                        </li>
                    </ul>
                    <a href="{{ route('customer.services.index') }}" class="text-green-600 font-medium hover:text-green-800 flex items-center group-hover:translate-x-2 transition-transform">
                        Tìm hiểu thêm
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('customer.services.index') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                <span class="font-medium">Xem tất cả dịch vụ</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Liên hệ -->
<section class="bg-indigo-600 text-white py-20 text-center">
    <div class="container mx-auto px-6" data-aos="zoom-in-up">
        <h2 class="text-3xl font-bold mb-4">Liên Hệ Với Chúng Tôi</h2>
        <p class="mb-6 text-lg">Chúng tôi luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p>
        <a href="#" class="bg-white text-indigo-600 px-8 py-4 rounded-lg text-lg shadow hover:bg-gray-200 transition">Liên hệ ngay</a>
    </div>
</section>

<!-- AOS script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
    


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
@endsection