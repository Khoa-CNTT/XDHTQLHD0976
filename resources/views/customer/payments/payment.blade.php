<!-- MoMo Payment Form -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-pink-500">
            <rect width="20" height="14" x="2" y="5" rx="2" />
            <line x1="2" x2="22" y1="10" y2="10" />
        </svg>
        Thanh toán qua MoMo
    </h3>
    
    <div class="mb-4">
        <p class="text-gray-600">Số tiền thanh toán: <span class="font-semibold text-gray-800">{{ number_format($contract->total_price, 0, ',', '.') }} VNĐ</span></p>
    </div>

    @if($contract->status === 'Chờ xử lý')
        <form action="{{ route('momo.payment', $contract->id) }}" method="POST">
            @csrf
            <div class="flex items-center">
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-medium py-2 px-4 rounded flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v4h4v2h-4v4h-2v-4H7v-2h4z"/>
                    </svg>
                    Thanh toán MoMo
                </button>
            </div>
        </form>
    @elseif($payment && $payment->method === 'MoMo')
        <div class="bg-gray-100 p-4 rounded">
            <div class="text-sm text-gray-700">
                <p class="mb-2">
                    <span class="font-medium">Trạng thái:</span> 
                    @if($payment->status === 'Hoàn Thành')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Đã thanh toán
                        </span>
                    @elseif($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Đang xử lý
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $payment->status }}
                        </span>
                    @endif
                </p>
                @if($payment->transaction_id)
                    <p class="mb-2"><span class="font-medium">Mã giao dịch:</span> {{ $payment->transaction_id }}</p>
                @endif
                <p class="mb-2"><span class="font-medium">Ngày thanh toán:</span> {{ $payment->date->format('d/m/Y H:i:s') }}</p>
                <p><span class="font-medium">Số tiền:</span> {{ number_format($payment->amount, 0, ',', '.') }} VNĐ</p>
            </div>
            
            @if($payment->status === 'Đang Xử Lý' || $payment->status === 'Đang Đợi')
                <div class="mt-4">
                    <a href="{{ route('momo.query', $payment->order_id) }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Kiểm tra trạng thái
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>