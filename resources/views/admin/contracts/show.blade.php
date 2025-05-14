@extends('layouts.admin')
@section('title', 'Chi tiết hợp đồng')
@section('content')

<div class="max-w-6xl mx-auto mt-8 mb-10">
    <!-- Header với các nút chức năng -->
    <div class="flex items-center justify-between mb-6 bg-white rounded-xl shadow-md p-5 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800">Chi tiết hợp đồng #{{ $contract->contract_number }}</h2>
        <div class="flex space-x-3">
            @if($contract->signatures->isNotEmpty() && $contract->signatures->first()->isFullySigned())
            <a href="{{ route('admin.contracts.pdf', $contract->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Tải PDF
            </a>
            @endif
            <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Chỉnh sửa
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Trở lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Cột thông tin hợp đồng -->
        <div class="md:col-span-2 space-y-6">
            <!-- Thông tin chính của hợp đồng -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Thông tin hợp đồng</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Mã hợp đồng</div>
                                <div class="mt-1 text-lg font-semibold text-gray-900">{{ $contract->contract_number }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Dịch vụ</div>
                                <div class="mt-1 text-lg text-gray-900">{{ $contract->service->service_name }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Ngày bắt đầu</div>
                                <div class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Ngày kết thúc</div>
                                <div class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Trạng thái</div>
                                <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-sm font-medium
                                        @switch($contract->status)
                                            @case('Chờ xử lý') bg-yellow-100 text-yellow-800 @break
                                            @case('Hoạt động') bg-green-100 text-green-800 @break
                                            @case('Hoàn thành') bg-blue-100 text-blue-800 @break
                                            @case('Đã huỷ') bg-red-100 text-red-800 @break
                                            @case('Yêu cầu huỷ') bg-orange-100 text-orange-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                    {{ $contract->status }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Trạng thái thanh toán</div>
                                <span class="px-3 py-1 rounded 
                {{ $isPaid ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $isPaid ? 'Đã thanh toán' : 'Chưa thanh toán' }}
            </span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Tổng tiền</div>
                                <div class="mt-1 text-xl font-bold text-gray-900">{{ number_format($contract->total_price, 0, ',', '.') }} VND</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Ngày thanh toán cuối</div>
                                <div class="mt-1 text-gray-900">{{ $contract->last_payment_date ? \Carbon\Carbon::parse($contract->last_payment_date)->format('d/m/Y') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Thông tin khách hàng</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Họ tên</div>
                                <div class="mt-1 text-lg font-semibold text-gray-900">{{ optional($contract->customer)->user->name ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Email</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->user->email ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Số điện thoại</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->user->phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Số CCCD</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->user->identity_card ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Ngày sinh</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->user->dob ? date('d/m/Y', strtotime(optional($contract->customer)->user->dob)) : 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Công ty</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->company_name ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500">Mã số thuế</div>
                                <div class="mt-1 text-gray-900">{{ optional($contract->customer)->tax_code ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách thanh toán -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Lịch sử thanh toán</h3>
                </div>
                <div class="p-6">
                    @if($contract->payments && $contract->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã giao dịch</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phương thức</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số tiền</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($contract->payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->transaction_id ?? $payment->order_id ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->method }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($payment->status)
                                                @case('Hoàn Thành') bg-green-100 text-green-800 @break
                                                @case('Đang Xử Lý') bg-yellow-100 text-yellow-800 @break
                                                @case('Thất Bại') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-6 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p>Chưa có thanh toán nào cho hợp đồng này</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Cột thông tin chữ ký và các nút hành động -->
        <div class="space-y-6">
            <!-- Thông tin chữ ký -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Chữ ký hợp đồng</h3>
                </div>

                @php
                    $signature = $contract->signatures->first();
                    // Kiểm tra xem signature_image có phải là base64 hay không
                    $signatureImageSrc = $signature && Str::startsWith($signature->signature_image, 'data:image')
                        ? $signature->signature_image
                        : ($signature ? 'data:image/png;base64,' . $signature->signature_image : null);

                    // Lấy chữ ký admin từ base64
                    $adminSignatureBase64 = $signature ? $signature->admin_signature_image : null;
                @endphp

                <div class="p-6 space-y-6">
                    <!-- Chữ ký khách hàng -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-700 mb-3">Chữ ký của khách hàng</h4>
                        <div class="border p-4 rounded bg-white flex flex-col items-center justify-center" style="min-height: 170px;">
                            @if($signature && $signature->signature_image)
                                <img src="{{ $signatureImageSrc }}" alt="Chữ ký khách hàng" class="max-h-24 mx-auto mb-3">
                                <p class="font-semibold text-blue-700 text-lg underline underline-offset-4 drop-shadow">{{ $signature->customer_name }}</p>
                                <p class="text-gray-600 text-sm mt-1">Đã ký ngày: {{ \Carbon\Carbon::parse($signature->signed_at)->format('d/m/Y H:i') }}</p>
                            @else
                                <div class="text-center text-gray-400 py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>Chưa có chữ ký</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Chữ ký admin -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-700 mb-3">Chữ ký của đơn vị cung cấp</h4>
                        <div class="border p-4 rounded bg-white flex flex-col items-center justify-center" style="min-height: 170px;">
                            @if($contract->status === 'Hoàn thành' && $adminSignatureBase64)
                                <img src="{{ $adminSignatureBase64 }}" alt="Chữ ký admin" class="max-h-24 mx-auto mb-3">
                                <p class="font-semibold text-blue-700 text-lg underline underline-offset-4 drop-shadow">{{ $signature->admin_name ?? 'Phạm Quang Ngà' }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ $signature->admin_position ?? 'Giám đốc' }}</p>
                                <p class="text-gray-600 text-sm mt-1">Đã ký ngày: {{ \Carbon\Carbon::parse($signature->admin_signed_at)->format('d/m/Y H:i') }}</p>
                            @elseif($contract->status === 'Hoàn thành')
                                <img src="{{ asset('storage/signatures/admin_signature.png') }}" alt="Chữ ký admin" class="max-h-24 mx-auto mb-3">
                                <p class="font-semibold text-blue-700 text-lg underline underline-offset-4 drop-shadow">Phạm Quang Ngà</p>
                                <p class="text-gray-600 text-sm mt-1">Giám đốc</p>
                            @else
                                <div class="text-center text-gray-400 py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>Chữ ký sẽ được thêm sau khi hợp đồng hoàn thành</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Các hành động với hợp đồng -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Hành động</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($contract->status === 'Yêu cầu huỷ')
                    <form action="{{ route('admin.contracts.confirmCancel', $contract->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Xác nhận huỷ hợp đồng
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.contracts.updateStatus', $contract->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="block text-sm font-medium text-gray-700">Cập nhật trạng thái:</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="Chờ xử lý" {{ $contract->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="Hoạt động" {{ $contract->status == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="Hoàn thành" {{ $contract->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="Đã huỷ" {{ $contract->status == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
