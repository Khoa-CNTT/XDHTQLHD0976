@extends('layouts.customer')

@section('title', 'Trang Chủ ')

@section('content')

<div class="container mx-auto">
    {{-- Thanh hình ảnh chạy - sử dụng Alpine.js --}}
    <section 
        x-data="{
                images: [
                '/banners/banner1.jpg',
                '/banners/banner2.png',
                '/banners/banner.jpg',
                '/banners/banner4.png',
                '/banners/gpt.png',
       
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
            :style="transform: translateX(-${currentIndex * 100}%);"
        >
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
                    <li><a href="{{ route('customer.services.filter', 'Tất Cả Dịch Vụ') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Tất Cả Dịch Vụ</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Phần mềm') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Phần Mềm</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Phần cứng') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Phần Cứng</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Nhà mạng') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 rounded-lg transition-colors">Nhà Mạng</a></li>
                </ul>
            </nav>
            </nav>
        </div>
    </div>

    {{-- Danh sách hợp đồng dịch vụ --}}
    <div class="grid md:grid-cols-3 gap-6 mt-6">
        @forelse($services as $service)
        <div class="bg-white-800 p-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-2 glass-effect">
            
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
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->service_name }}</h3>
                <p class="text-gray-600 mb-2 line-clamp-3">{{ $service->description }}</p>
                <p class="text-gray-600 mb-1"><strong>Loại dịch vụ:</strong> {{ $service->service_type }}</p>
                <p class="text-gray-600 mb-4"><strong>Giá:</strong> 
                    <span class="text-green-600 font-bold">{{ number_format($service->price, 0, ',', '.') }} VND</span>
                </p>
            </div>
            <div>
                <a href="{{ route('customer.services.show', $service->id) }}" 
                   class="text-sm px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition inline-block">
                    Xem Hợp Đồng
                </a>
            </div>
        </div>
        @empty
        <p class="text-gray-600">Chúng tôi rất tiếc ,không có dịch vụ nào bạn đang tìm kiếm cả!!!</p>
        @endforelse
    </div>
    
    
    <!-- Hiển thị phân trang -->
    <div class="mt-6">
        <div class="flex justify-center space-x-4">
            @if ($services->onFirstPage())
                <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-l-lg">Trang đầu</span>
            @else
                <a href="{{ $services->previousPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded-l-lg hover:bg-blue-700">Trang đầu</a>
            @endif

            <span class="px-4 py-2 text-gray-500">Trang {{ $services->currentPage() }} / {{ $services->lastPage() }}</span>

            @if ($services->hasMorePages())
                <a href="{{ $services->nextPageUrl() }}" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">Trang sau</a>
            @else
                <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-r-lg">Trang sau</span>
            @endif
        </div>
    </div>

    {{-- Giới thiệu về web --}}
    <div class="mt-16 bg-gray-100 py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Giới Thiệu Về Chúng Tôi</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Chúng tôi cung cấp các giải pháp công nghệ thông tin hiện đại, giúp doanh nghiệp của bạn phát triển mạnh mẽ trong thời đại số hóa.</p>
        </div>
    </div>

    {{-- Thông tin chi tiết --}}
    <div class="mt-16 bg-white py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Thông Tin Chi Tiết</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <h3 class="text-xl font-semibold mb-2">Dịch Vụ Đa Dạng</h3>
                    <p class="text-gray-600">Chúng tôi cung cấp nhiều dịch vụ từ phát triển phần mềm đến quản trị hệ thống.</p>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-semibold mb-2">Đội Ngũ Chuyên Nghiệp</h3>
                    <p class="text-gray-600">Đội ngũ chuyên gia giàu kinh nghiệm, luôn sẵn sàng hỗ trợ bạn.</p>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-semibold mb-2">Hỗ Trợ 24/7</h3>
                    <p class="text-gray-600">Chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tổng quan sản phẩm --}}
    <div class="mt-16 bg-gray-100 py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Tổng Quan Sản Phẩm</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Khám phá các sản phẩm và dịch vụ nổi bật của chúng tôi, được thiết kế để đáp ứng mọi nhu cầu của bạn.</p>
        </div>
    </div>

    {{-- Liên hệ --}}
    <div class="mt-16 bg-white py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Liên Hệ Với Chúng Tôi</h2>
            <p class="text-gray-600 mb-6">Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi.</p>
            <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition-colors">Liên Hệ Ngay</a>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection