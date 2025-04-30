@extends('layouts.customer')

@section('title', 'Danh sách dịch vụ')
<style>
    /* CSS cho danh mục dịch vụ */
.nav-category a {
    color: #4a5568; /* Màu xám mặc định */
    font-weight: 500;
    transition: color 0.3s ease, font-weight 0.3s ease;
}

.nav-category a:hover {
    color: #2563eb; /* Màu xanh khi hover */
    font-weight: 600; /* Tăng độ đậm khi hover */
}

.nav-category a.active {
    color: #2563eb; /* Màu xanh cho danh mục đang được chọn */
    font-weight: 700; /* Đậm hơn khi được chọn */
    border-bottom: 2px solid #2563eb; /* Đường gạch chân */
}
/* CSS cho thông báo không có dịch vụ */
.no-services {
    color: #258aa1; /* Màu đỏ nổi bật */
    font-size: 1.25rem; /* Tăng kích thước chữ */
    font-weight: 600; /* Tăng độ đậm */
    text-align: center; /* Căn giữa */
    margin-top: 2rem; /* Thêm khoảng cách phía trên */
    animation: fadeIn 0.5s ease-in-out; /* Hiệu ứng xuất hiện */
}

/* Hiệu ứng fade-in */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
@section('content')
<div class="container mx-auto">
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
    :style="`transform: translateX(-${currentIndex * 100}%);`"
>
    <template x-for="(image, index) in images" :key="index">
        <div class="w-full flex-shrink-0 h-full">
            <img :src="image" class="w-full h-full object-cover" />
        </div>
    </template>
</div>

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
</div>



@php
    $colors = ['text-red-500', 'text-blue-500', 'text-green-500', 'text-yellow-500', 'text-purple-500'];
@endphp
<div class="container mx-auto">
     {{-- Danh sách hợp đồng dịch vụ --}}
     <div class="grid md:grid-cols-3 gap-6 mt-6">
    @forelse($services as $service)
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border border-gray-200 flex flex-col justify-between min-h-[280px] relative">

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
            <img src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/default.jpg') }}" 
            alt="{{ $service->service_name }}" 
            class="w-full h-48 object-cover mb-4 rounded-lg">
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
        <p class="no-services">Chúng tôi rất tiếc, không có dịch vụ nào bạn đang tìm kiếm cả!!!</p>
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
    
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection