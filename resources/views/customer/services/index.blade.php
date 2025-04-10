@extends('layouts.customer')

@section('title', 'Danh sách dịch vụ')

@section('content')
 <!-- Danh mục và Tìm kiếm -->
<div class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
        
        {{-- Danh mục dịch vụ --}}
        <nav>
            <ul class="flex flex-wrap gap-3">
                @php
                    $categories = ['Tất Cả', 'Phần mềm', 'Phần cứng', 'Nhà mạng'];
                @endphp
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('customer.services.filter', $category) }}"
                           class="px-4 py-2 rounded transition-all duration-200 text-sm font-medium
                                  {{ request()->is('customer/services/filter/' . $category) 
                                     ? 'bg-gray-200 text-gray-900' 
                                     : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                            {{ $category }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- Tìm kiếm dịch vụ --}}
        <form action="{{ route('customer.services.search') }}" method="GET" class="relative w-full md:w-1/3">
            <input 
                type="text" 
                name="query" 
                placeholder="Tìm kiếm dịch vụ..." 
                value="{{ request('query') }}" 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
            </svg>
        </form>
    </div>
</div>

<div class="container mx-auto">
    <h2 class="text-3xl font-bold mb-4">Danh sách dịch vụ: {{ $type }}</h2>
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
    
</div>
@endsection