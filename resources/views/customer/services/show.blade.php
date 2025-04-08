@extends('layouts.customer')

@section('title', 'Chi Tiết Dịch Vụ')

@section('content')
<div class="container mx-auto mt-6">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-3xl font-bold mb-4">{{ $service->service_name }}</h2>
        <div class="mt-6">
            <h3 class="text-2xl font-semibold mb-4">Nội dung chi tiết</h3>
            <p class="text-gray-600 leading-relaxed">{{ $service->content }}</p>
        </div>
        <p class="text-gray-600 mb-2"><strong>Loại dịch vụ:</strong> {{ $service->service_type }}</p>
        <p class="text-gray-600 mb-4"><strong>Giá:</strong> 
            <span class="text-green-600 font-bold">{{ number_format($service->price, 0, ',', '.') }} VND</span>
        </p>
        <div class="flex space-x-4 mt-6">
            <a href="{{ route('customer.services.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Quay Lại
            </a>
            <a href="#" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Yêu Cầu Hợp Đồng
            </a>
        </div>
    </div>
</div>
@endsection