<!-- filepath: c:\Users\ASUS_TUF\Documents\QuanLyHopDong\ConT_management\resources\views\customer\dashboard.blade.php -->
@extends('layouts.customer')

@section('title', 'Trang Chủ Khách Hàng')

@section('content')

<div class="container mx-auto">
    <!-- Danh mục và Tìm kiếm -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('customer.services.filter', 'Tất Cả') }}" class="text-gray-700 hover:text-blue-600">Tất Cả Dịch Vụ</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Phần mềm') }}" class="text-gray-700 hover:text-blue-600">Phần Mềm</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Phần cứng') }}" class="text-gray-700 hover:text-blue-600">Phần Cứng</a></li>
                    <li><a href="{{ route('customer.services.filter', 'Nhà mạng') }}" class="text-gray-700 hover:text-blue-600">Nhà Mạng</a></li>
                </ul>
            </nav>
            </nav>
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
            <p class="text-gray-600">Không có dịch vụ nào.</p>
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



@endsection