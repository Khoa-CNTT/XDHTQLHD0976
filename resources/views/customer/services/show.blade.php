@extends('layouts.customer')

@section('title', 'Chi Tiết Dịch Vụ')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <nav class="text-sm text-gray-500 mb-4">
        <a href="{{ route('customer.dashboard') }}" class="hover:underline text-blue-600">Trang chủ</a> /
        <a href="{{ route('customer.services.index') }}" class="hover:underline text-blue-600">Dịch vụ</a> /
        <span class="text-gray-700">{{ $service->service_name }}</span>
    </nav>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">    
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6 border border-gray-200">
            <h2 class="text-3xl font-bold text-blue-800 mb-4">
                <strong>Tên dịch vụ:</strong> {{ $service->service_name }}
            </h2>
            <p class="text-gray-700 text-md mb-4">
                <strong>Loại dịch vụ:</strong> {{ $service->service_type }}
            </p>
            <div class="text-gray-700 text-md space-y-4 mb-4">
                <div>
                    <strong class="block mb-1">Mô tả:</strong>
                    <pre class="whitespace-pre-wrap font-sans">{!! e($service->description) !!}</pre>
                </div>
                <div>
                    <strong class="block mb-1">Thông tin chi tiết của dịch vụ:</strong>
                    <pre class="whitespace-pre-wrap font-sans">{!! e($service->content) !!}</pre>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 space-y-6">
            <img src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/default.jpg') }}" 
            alt="{{ $service->service_name }}" 
            class="w-full h-60 object-cover rounded-xl shadow">
       
            <div>
                <span class="text-gray-500">Giá dịch vụ</span>
                <div class="text-2xl font-bold text-pink-600">
                    {{ number_format($service->price, 0, ',', '.') }} VND
                </div>
            </div>         
            <form id="contractForm" action="{{ route('customer.contracts.sign', $service->id) }}" method="GET">
                @csrf
                <label class="block text-gray-700 font-semibold mb-2">Chọn thời hạn hợp đồng:</label>
                <div class="flex space-x-4 mb-6">
                    @php
                        $durations = [
                            '6 tháng' => '6 Tháng',
                            '1 năm' => '1 Năm',
                            '3 năm' => '3 Năm'
                        ];
                    @endphp
            
                    <!-- Các nút bấm chọn thời gian hợp đồng -->
                    @foreach($durations as $key => $label)
                        <button type="button" 
                                class="contract-option px-4 py-2 rounded-lg border border-gray-300 text-gray-700 transition-all duration-200" 
                                onclick="document.getElementById('duration').value = '{{ $key }}'">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            
                <!-- Trường ẩn để lưu giá trị thời gian hợp đồng -->
                <input type="hidden" id="duration" name="duration" value="6_thang">
            
                <div class="flex flex-col space-y-3 mt-4">
                    <!-- Nút quay lại -->
                    <a href="{{ route('customer.dashboard') }}"
                       class="w-full text-center bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 hover:scale-105 transition">
                        ← Quay Lại
                    </a>
            
                    <!-- Nút gửi yêu cầu hợp đồng -->
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 hover:scale-105 transition transform duration-300 ease-in-out text-center block">
                        📝 Gửi Yêu Cầu Hợp Đồng
                    </button>
                </div>
            </form>
            
            
        </div>
    </div>
</div>


             
<script>


 // Kiểm tra trước khi gửi form
 document.getElementById('contractForm').onsubmit = function(event) {
        var duration = document.getElementById('duration').value;
        if (!duration) {
            event.preventDefault();
            alert("Vui lòng chọn thời gian hợp đồng.");
        }
    };




    const buttons = document.querySelectorAll('.contract-option');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
            });

            this.classList.add('bg-blue-600', 'text-white');
        });

        button.addEventListener('mouseenter', function() {
            this.classList.remove('hover:bg-blue-100');
        });
    });
</script>
@endsection
