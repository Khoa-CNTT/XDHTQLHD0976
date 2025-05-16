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
                <strong>Loại dịch vụ:</strong> {{ $service->category->name ?? 'Không có danh mục' }}
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
                <div class="text-2xl font-bold text-pink-600" id="price-display">
                    Vui lòng chọn thời hạn hợp đồng
                </div>
            </div>         
            <form id="contractForm" action="{{ route('customer.contracts.sign', $service->id) }}" method="GET">
                @csrf
                <label class="block text-gray-700 font-semibold mb-2">Chọn thời hạn hợp đồng:</label>
                <div class="flex flex-wrap gap-2 mb-6">
                    @if($availableDurations->count() > 0)
                        @foreach($availableDurations as $contractDuration)
                            <button type="button" 
                                    data-duration-id="{{ $contractDuration->duration_id }}"
                                    data-duration-code="{{ Str::slug($contractDuration->duration->label, '_') }}"
                                    data-price="{{ $contractDuration->price }}"
                                    class="contract-option px-4 py-2 rounded-lg border border-gray-300 text-gray-700 transition-all duration-200" 
                                    onclick="selectDuration('{{ Str::slug($contractDuration->duration->label, '_') }}', this, {{ $contractDuration->price }})">
                                {{ $contractDuration->duration->label }}
                            </button>
                        @endforeach
                    @else
                        <div class="w-full text-center py-3 text-gray-500">
                            Chưa có thời hạn nào được thiết lập cho dịch vụ này
                        </div>
                    @endif
                </div>
            
                <!-- Trường ẩn để lưu giá trị thời gian hợp đồng -->
                <input type="hidden" id="duration" name="duration" value="">
                <input type="hidden" id="selected_price" name="selected_price" value="">

                <div class="flex flex-col space-y-3 mt-4">
                  
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 hover:scale-105 transition transform duration-300 ease-in-out text-center block"
                            {{ $availableDurations->count() == 0 ? 'disabled' : '' }}
                            {{ $availableDurations->count() == 0 ? 'style=opacity:0.5;cursor:not-allowed' : '' }}>
                        📝 Gửi Yêu Cầu Hợp Đồng
                    </button>
                      <a href="{{ route('customer.dashboard') }}"
                       class="w-full text-center bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 hover:scale-105 transition">
                        ← Quay Lại
                    </a>
            
                </div>
            </form>
            
          
        </div>
    </div>
</div>


             
<script>
    function selectDuration(value, button, price) {
        // Gán giá trị thời hạn hợp đồng vào input ẩn
        document.getElementById('duration').value = value;
        document.getElementById('selected_price').value = price;

        // Thay đổi giao diện nút được chọn
        const buttons = document.querySelectorAll('.contract-option');
        buttons.forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-700');
        });
        button.classList.add('bg-blue-600', 'text-white');
        button.classList.remove('text-gray-700');
        
        // Cập nhật hiển thị giá
        document.getElementById('price-display').textContent = 
            new Intl.NumberFormat('vi-VN').format(price) + ' VND';
    }

    // Kiểm tra trước khi gửi form
    document.getElementById('contractForm').onsubmit = function(event) {
        var duration = document.getElementById('duration').value;
        if (!duration) {
            event.preventDefault();
            alert("Vui lòng chọn thời hạn hợp đồng trước khi gửi.");
        }
    };
</script>
@endsection
