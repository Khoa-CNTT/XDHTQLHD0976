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
@if (session('error'))
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif
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
<div class="bg-white shadow-sm mt-5 border border-gray-200 rounded-2xl px-1 py-0">
        <div class="container mx-auto px-4 py-3 flex gap-x-10 items-center ">
            <form action="{{ route('customer.services.search') }}" method="GET" class="relative w-1/3 mr-6 ">
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

@if (session('search_error'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">{{ session('search_error') }}</p>
            </div>
        </div>
    </div>
@endif

@php
    $colors = ['text-red-500', 'text-blue-500', 'text-green-500', 'text-yellow-500', 'text-purple-500'];
@endphp

{{-- Danh sách hợp đồng dịch vụ --}}
<div class="grid md:grid-cols-3 gap-6 mt-6">
    @forelse($services as $service)
    <div class="flex flex-col justify-between bg-white-800 p-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-2 glass-effect">
        
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
    <div class="col-span-3 py-16 px-4">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-blue-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy dịch vụ</h3>
            <p class="text-gray-600 mb-6">Chúng tôi rất tiếc, không có dịch vụ nào phù hợp với tìm kiếm của bạn.</p>
            
            @if(request('query'))
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Gợi ý:</p>
                    <ul class="text-sm text-gray-600 list-disc list-inside">
                        <li>Kiểm tra lại chính tả</li>
                        <li>Thử sử dụng các từ khóa khác</li>
                        <li>Sử dụng các thuật ngữ chung hơn</li>
                    </ul>
                </div>
            @endif
            
            <a href="{{ route('customer.services.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Xem tất cả dịch vụ
            </a>
        </div>
    </div>
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