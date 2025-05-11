@extends('layouts.customer')

@section('title', 'Lịch sử thanh toán')

@section('content')
<!-- Banner thanh toán với form tìm kiếm -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 py-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left text-white">
                <h1 class="text-4xl font-bold mb-4">Lịch Sử Thanh Toán</h1>
                <p class="text-indigo-100 text-lg max-w-lg mb-6">
                    Theo dõi và quản lý tất cả các giao dịch thanh toán của bạn một cách an toàn và tiện lợi.
                </p>
                
                <!-- Form tìm kiếm -->
                <form action="{{ route('customer.payments.index') }}" method="GET" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-2 mt-2">
                    <div class="flex-grow">
                        <input type="text" name="search" placeholder="Tìm kiếm theo mã giao dịch hoặc số tiền..." 
                            class="w-full px-4 py-2 rounded-lg border-0 focus:ring-2 focus:ring-purple-300 text-gray-700" 
                            value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-white text-purple-600 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Tìm kiếm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-10 max-w-6xl">
    <!-- Thẻ tổng quan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-indigo-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tổng giao dịch</p>
                <p class="text-2xl font-bold text-gray-800">{{ $payments->total() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-green-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Hoàn thành</p>
                <p class="text-2xl font-bold text-gray-800">{{ $payments->where('status', 'Hoàn Thành')->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Đang xử lý</p>
                <p class="text-2xl font-bold text-gray-800">{{ $payments->where('status', 'Đang Xử Lý')->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-purple-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tổng tiền</p>
                <p class="text-xl font-bold text-gray-800">{{ number_format($payments->sum('amount'), 0, ',', '.') }} VND</p>
            </div>
        </div>
    </div>

    <!-- Danh sách giao dịch -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Lịch Sử Giao Dịch</h2>
            <div class="flex items-center space-x-1 text-xs text-gray-500">
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-green-100 border border-green-600 mr-1"></span>
                    <span>Hoàn thành</span>
                </div>
                <div class="mx-1">|</div>
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-yellow-100 border border-yellow-600 mr-1"></span>
                    <span>Đang xử lý</span>
                </div>
                <div class="mx-1">|</div>
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-red-100 border border-red-600 mr-1"></span>
                    <span>Thất bại</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-left">
                        <th class="p-3 font-medium">Mã giao dịch</th>
                        <th class="p-3 font-medium">Ngày thanh toán</th>
                        <th class="p-3 font-medium">Số tiền</th>
                        <th class="p-3 font-medium">Phương thức</th>
                        <th class="p-3 font-medium">Trạng thái</th>
                        <th class="p-3 font-medium text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="p-3">
                            <div class="font-medium text-gray-800">{{ $payment->transaction_id ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">ID: #{{ $payment->id }}</div>
                        </td>
                        <td class="p-3">
                            <div class="font-medium text-gray-800">{{ $payment->date->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->date->format('H:i:s') }}</div>
                        </td>
                        <td class="p-3">
                            <div class="font-medium text-emerald-600">{{ number_format($payment->amount, 0, ',', '.') }} VND</div>
                            @if(isset($payment->contract))
                                <div class="text-xs text-gray-500">{{ $payment->contract->service->service_name ?? 'Dịch vụ không xác định' }}</div>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex items-center">
                                @if($payment->method == 'Thẻ tín dụng')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @elseif($payment->method == 'Chuyển khoản')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                @elseif($payment->method == 'Ví điện tử')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                                <span>{{ $payment->method }}</span>
                            </div>
                        </td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium inline-block
                                {{ $payment->status === 'Hoàn Thành' ? 'bg-green-100 text-green-600' : 
                                ($payment->status === 'Đang Xử Lý' ? 'bg-yellow-100 text-yellow-600' : 
                                'bg-red-100 text-red-600') }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <a href="{{ route('customer.payments.show', $payment->id) }}" 
                               class="inline-flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg px-4 py-2 text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center">
                            <div class="flex flex-col items-center py-10">
                                <img src="https://cdn-icons-png.flaticon.com/512/9841/9841570.png" alt="No payments" class="w-32 h-32 mb-4 opacity-60">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có giao dịch nào</h3>
                                <p class="text-gray-500 mb-6 max-w-md text-center">Bạn chưa có giao dịch thanh toán nào. Khi bạn thanh toán cho dịch vụ, lịch sử sẽ xuất hiện ở đây.</p>
                                <a href="{{ route('customer.services.index') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                    Khám phá dịch vụ
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>

    <!-- Thông tin về thanh toán -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Thanh toán an toàn</h3>
            <p class="text-gray-600 text-sm">Tất cả các giao dịch đều được bảo mật và xử lý qua cổng thanh toán tin cậy với mã hóa SSL tiêu chuẩn.</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Hóa đơn điện tử</h3>
            <p class="text-gray-600 text-sm">Mỗi giao dịch đều có hóa đơn điện tử đi kèm, bạn có thể tải về và lưu trữ để sử dụng cho mục đích kế toán.</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Đa dạng phương thức thanh toán</h3>
            <p class="text-gray-600 text-sm">Hỗ trợ nhiều phương thức thanh toán như thẻ tín dụng, chuyển khoản ngân hàng và ví điện tử.</p>
        </div>
    </div>

    <!-- FAQ -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-10">
        <h2 class="text-xl font-semibold mb-6 text-gray-800">Câu hỏi thường gặp về thanh toán</h2>
        
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="font-medium text-gray-800 mb-2">Làm thế nào để tôi có thể xem chi tiết một khoản thanh toán?</h3>
                <p class="text-gray-600 text-sm">Bạn có thể nhấn vào nút "Chi tiết" bên cạnh mỗi giao dịch để xem thông tin đầy đủ, bao gồm biên lai và chi tiết thanh toán.</p>
            </div>
            
            <div class="border-b border-gray-100 pb-4">
                <h3 class="font-medium text-gray-800 mb-2">Nếu thanh toán của tôi bị thất bại, tôi phải làm gì?</h3>
                <p class="text-gray-600 text-sm">Nếu thanh toán của bạn hiển thị trạng thái "Thất bại", bạn có thể thử thanh toán lại hoặc liên hệ với bộ phận hỗ trợ của chúng tôi để được trợ giúp.</p>
            </div>
            
            <div>
                <h3 class="font-medium text-gray-800 mb-2">Tôi có thể yêu cầu hoàn tiền cho một khoản thanh toán không?</h3>
                <p class="text-gray-600 text-sm">Để yêu cầu hoàn tiền, vui lòng liên hệ với bộ phận hỗ trợ khách hàng và cung cấp mã giao dịch của bạn. Yêu cầu hoàn tiền sẽ được xử lý theo chính sách hoàn tiền của chúng tôi.</p>
            </div>
        </div>
    </div>
</div>
@endsection