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
 <!-- Danh mục và Tìm kiếm -->
<!-- Danh mục và Tìm kiếm -->
<div class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        {{-- Danh mục dịch vụ --}}
        <nav>
            <ul class="flex space-x-6">
                @php
                    $categories = ['Tất Cả Dịch Vụ', 'Phần Mềm', 'Phần Cứng', 'Nhà Mạng'];
                @endphp
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('customer.services.filter', $category) }}"
                        class="text-gray-700 hover:text-blue-600" {{ request()->is('customer/services/filter/' . $category) ? 'font-semibold text-blue-600' : '' }}">
                            {{ $category }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- Tìm kiếm dịch vụ --}}
        <form action="{{ route('customer.services.search') }}" method="GET" class="relative w-1/3 mb-4">
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
    </div>
</div>

@php
    $colors = ['text-red-500', 'text-blue-500', 'text-green-500', 'text-yellow-500', 'text-purple-500'];
@endphp
<div class="container mx-auto">
    {{-- <h2 class="text-3xl font-bold mb-4"> {{ $type }}</h2> --}}
     {{-- Danh sách hợp đồng dịch vụ --}}
     <div class="grid md:grid-cols-3 gap-6 mt-6">
    @forelse($services as $service)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border border-gray-200 flex flex-col justify-between min-h-[280px] relative">

            <!-- Nhãn "Mới" (Bao phủ góc trên trái) -->
            @if($service->created_at && $service->created_at->gt(now()->subDays(7)))
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
        {{ $services->links() }}
    </div>
    
</div>
@endsection