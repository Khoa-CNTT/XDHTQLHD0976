@extends('layouts.customer')

@section('title', 'Chi Tiết Hợp Đồng')
@if(session()->has('success'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endpush
@endif
@section('content')
<div class="max-w-5xl mx-auto mt-10 mb-20 min-h-screen pb-24">
<div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 mb-10">
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Chi Tiết Hợp Đồng</h1>

    <!-- Grid thông tin -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-sm font-medium text-gray-900">Tên Dịch Vụ</label>
            <p class="mt-1 text-gray-600">
                @if($contract->service)
                    {{ $contract->service->service_name }}
                @else
                    <span class="text-red-500">Dịch vụ không tồn tại</span>
                @endif
            </p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-900">Loại Dịch Vụ</label>
            <p class="mt-1  text-gray-600"> {{ $contract->service->category->name ?? 'Chưa xác định' }}</p>
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
        <div >
            <label class="block text-sm font-medium text-gray-900">Tổng giá trị hợp đồng</label>
            <p class="mt-1 text-gray-600">{{ number_format($contract->total_price, 0, ',', '.') }} VND</p>
        </div>
        
        @if($contract->signatures && $contract->signatures->count() > 0)
        <div>
            <label class="block text-sm font-medium text-gray-900">Thời hạn</label>
            <p class="mt-1 text-gray-600">
                @if($contract->signatures->first()->contractDuration && $contract->signatures->first()->contractDuration->duration)
                    {{ $contract->signatures->first()->contractDuration->duration->label }}
                @else
                    Không có thông tin
                @endif
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900">Ngày ký hợp đồng</label>
            <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($contract->signatures->first()->signed_at)->format('d/m/Y H:i:s') }}</p>
        </div>
        @endif
        
        @if($contract->status === 'Hoạt động' || $contract->status === 'Hoàn thành')
        <div>
            <label class="block text-sm font-medium text-gray-900">Ngày hết hạn</label>
            <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}</p>
        </div>
        @endif
        
        <div class="w-80 h-32 overflow-hidden rounded-lg">
            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $contract->service->image) }}" alt="Ảnh dịch vụ">
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

    <!-- Thông tin thanh toán -->
    @if($contract->payments && $contract->payments->count() > 0)
        <div class="bg-green-50 rounded-lg p-6 mb-8 border border-green-200">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Thông Tin Thanh Toán
            </h3>
            
            @foreach($contract->payments as $payment)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Phương thức thanh toán</label>
                        <p class="mt-1 text-gray-600">{{ $payment->method }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Số tiền</label>
                        <p class="mt-1 text-gray-600">{{ number_format($payment->amount, 0, ',', '.') }} VND</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Ngày thanh toán</label>
                        <p class="mt-1 text-gray-600">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Trạng thái</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm inline-block {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $payment->status }}
                            </span>
                        </p>
                    </div>
                    @if($payment->transaction_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Mã giao dịch</label>
                        <p class="mt-1 text-gray-600">{{ $payment->transaction_id }}</p>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($contract->status === 'Chờ xử lý')
    <form action="{{ route('customer.vnpay.payment', ['id' => $contract->id]) }}" method="POST">
    @csrf
    <div class="flex justify-between mt-6">
        <a href="{{ route('customer.contracts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Quay lại
        </a>
        @if ($contract->payments && $contract->payments->count() > 0)
            <div class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed">
                Đã gửi yêu cầu thanh toán
            </div>
        @else
            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
            <input type="hidden" name="amount" value="{{ $contract->total_price }}">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Thanh Toán Qua VNPay
            </button>
        @endif
    </div>
</form>
@else
    <div class="flex justify-between mt-8">
        <a href="{{ route('customer.contracts.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
            ← Quay lại danh sách
        </a>
        @if($contract->status === 'Hoạt động')
            <div class="px-6 py-3 bg-green-100 text-green-800 rounded-lg border border-green-200">
                <span class="font-semibold">Thời gian còn lại:</span>
                {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($contract->end_date), true) }}
                (Hết hạn ngày {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }})
            </div>
        @endif
    </div>
@endif
</div>

<!-- Thêm phần hướng dẫn thanh toán để tăng chiều cao -->
<div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-20">
    <h3 class="text-xl font-bold text-blue-800 mb-4">Thông tin hướng dẫn</h3>
    
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 mr-3">1</div>
                <h4 class="font-medium">Xem thông tin hợp đồng</h4>
            </div>
            <p class="text-sm text-gray-600">Kiểm tra kỹ các thông tin về dịch vụ, thời hạn và giá trị hợp đồng của bạn.</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 mr-3">2</div>
                <h4 class="font-medium">Thanh toán hợp đồng</h4>
            </div>
            <p class="text-sm text-gray-600">Nếu hợp đồng ở trạng thái "Chờ xử lý", bạn có thể thanh toán qua VNPay một cách an toàn.</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 mr-3">3</div>
                <h4 class="font-medium">Theo dõi trạng thái</h4>
            </div>
            <p class="text-sm text-gray-600">Sau khi thanh toán, hợp đồng sẽ được xử lý và chuyển sang trạng thái "Hoạt động".</p>
        </div>
    </div>
    
    <div class="mt-6 text-gray-600 text-sm">
        <p class="font-medium mb-2">Ghi chú về trạng thái hợp đồng:</p>
        <ul class="list-disc list-inside space-y-1 ml-2">
            <li><span class="font-medium text-yellow-600">Chờ xử lý:</span> Hợp đồng đã được tạo nhưng chưa thanh toán hoặc đang chờ xác nhận.</li>
            <li><span class="font-medium text-green-600">Hoạt động:</span> Hợp đồng đã được thanh toán và đang có hiệu lực.</li>
            <li><span class="font-medium text-blue-600">Hoàn thành:</span> Hợp đồng đã kết thúc thời hạn và được hoàn thành đầy đủ.</li>
            <li><span class="font-medium text-red-600">Đã huỷ:</span> Hợp đồng đã bị hủy bỏ theo yêu cầu hoặc do vi phạm điều khoản.</li>
        </ul>
    </div>
</div>
</div>
@endsection
