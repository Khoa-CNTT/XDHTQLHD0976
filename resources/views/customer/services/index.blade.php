@extends('layouts.customer')

@section('title', 'Danh sách dịch vụ')

@section('content')
 <!-- Danh mục và Tìm kiếm -->
 <div class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <nav>
            <ul class="flex space-x-6">
                <li><a href="{{ route('customer.services.filter', 'Tất Cả') }}" class="text-gray-700 hover:text-blue-600">Tất Cả Dịch Vụ</a></li>
                <li><a href="{{ route('customer.services.filter', 'Phần mềm') }}" class="text-gray-700 hover:text-blue-600">Phần Mềm</a></li>
                <li><a href="{{ route('customer.services.filter', 'Phần cứng') }}" class="text-gray-700 hover:text-blue-600">Phần Cứng</a></li>
                <li><a href="{{ route('customer.services.filter', 'An Ninh mạng') }}" class="text-gray-700 hover:text-blue-600">An Ninh Mạng</a></li>
            </ul>
        </nav>>
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
<div class="container mx-auto">
    <h2 class="text-3xl font-bold mb-4">Danh sách dịch vụ: {{ $type }}</h2>
     {{-- Danh sách hợp đồng dịch vụ --}}
     <div class="grid md:grid-cols-3 gap-6 mt-6">
        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $service->service_name }}</h3>
                <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                <p class="text-gray-600 mb-2"><strong>Loại dịch vụ:</strong> {{ $service->service_type }}</p>
                <p class="text-gray-600 mb-4"><strong>Giá:</strong> 
                    <span class="text-green-600 font-bold">{{ number_format($service->price, 0, ',', '.') }} VND</span>
                </p>
                <a href="{{ route('customer.services.show', $service->id) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Xem Hợp Đồng
                </a>
            </div>
        @empty
            <p class="text-gray-600">Không có dịch vụ nào.</p>
        @endforelse
    </div>

    <!-- Hiển thị phân trang -->
    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
@endsection