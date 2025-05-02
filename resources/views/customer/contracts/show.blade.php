@extends('layouts.customer')

@section('title', 'Chi Tiết Hợp Đồng')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Chi Tiết Hợp Đồng</h1>

    <!-- Grid thông tin -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-sm font-medium text-gray-900">Tên Dịch Vụ</label>
            <p class="mt-1 text-gray-600">{{ $contract->service->service_name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900">Loại Dịch Vụ</label>
            <p class="mt-1 text-gray-600">{{ $contract->service->service_type }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900">Giá Dịch Vụ</label>
            <p class="mt-1 text-gray-600">{{ number_format($contract->service->price, 0, ',', '.') }} VND</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900">Ngày Bắt Đầu</label>
            <p class="mt-1 text-gray-600">{{ $contract->start_date }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900">Trạng Thái Hợp Đồng</label>
            <p class="mt-1">
                <span class="px-3 py-1 rounded-full text-sm inline-block
                    {{ 
                        $contract->status === 'Chờ xử lý' ? 'bg-yellow-100 text-yellow-600' : 
                        ($contract->status === 'Hoạt động' ? 'bg-green-100 text-green-600' : 
                        ($contract->status === 'Hoàn thành' ? 'bg-blue-100 text-blue-600' : 
                        'bg-red-100 text-red-600'))
                    }}">
                    {{ $contract->status }}
                </span>
            </p>
        </div>
        @foreach ($contract->signatures as $signature)
        <div>
            <label class="block text-sm font-medium text-gray-700">Thời hạn</label>
            <p class="mt-1 text-gray-600">{{ $signature->duration }}</p>
        </div>
        @endforeach
        <div>
            <label class="block text-sm font-medium text-gray-900">Tổng giá trị hợp đồng</label>
            <p class="mt-1 text-gray-600">{{ number_format($contract->total_price, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="bg-gray-100 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">👤 Thông Tin Khách Hàng</h3>
        @if ($contract->customer)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-900">Tên</label>
                    <p class="mt-1 text-gray-600">{{ $contract->customer->user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900">Email</label>
                    <p class="mt-1 text-gray-600">{{ $contract->customer->user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900">Số điện thoại</label>
                    <p class="mt-1 text-gray-600">{{ $contract->customer->user->phone }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900">Địa chỉ</label>
                    <p class="mt-1 text-gray-600">{{ $contract->customer->user->address }}</p>
                </div>
            </div>
        @else
            <p class="text-red-500">Thông tin khách hàng không khả dụng.</p>
        @endif
    </div>

   
    

    @if ($contract->status === 'Chờ xử lý')
    {{-- <form action="{{ route('customer.vnpay.payment', $contract->id) }}" method="POST">
        @csrf
        <div class="flex justify-between mt-6">
            <a href="{{ route('customer.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Quay lại
            </a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Thanh Toán Qua VNPay
            </button>
        </div>
    </form> --}}
    
    <form action="{{ route('customer.momo.create', $contract->id) }}" method="POST">
        @if (session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif
        @csrf
        <div class="flex justify-between mt-6">
            <a href="{{ route('customer.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Quay lại
            </a>
        <div class="flex justify-between mt-6">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Thanh Toán Qua MOMO
            </button>
        </div>
    </form>
    @endif
    
    
</div>
@endsection
