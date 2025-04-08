@extends('layouts.customer')

@section('title', 'Danh sách dịch vụ')

@section('content')
<div class="container mt-4">
    <h2 class="text-xl font-bold mb-4">Danh sách dịch vụ: {{ $type }}</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $service->service_name }}</h3>
                <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                <p class="text-gray-600 mb-4"><strong>Loại:</strong> {{ $service->service_type }}</p>
                <p class="text-gray-600 mb-4"><strong>Giá:</strong> {{ number_format($service->price, 0, ',', '.') }} VND</p>
            </div>
        @empty
            <p class="text-gray-600">Không có dịch vụ nào thuộc loại "{{ $type }}".</p>
        @endforelse
    </div>
</div>
@endsection