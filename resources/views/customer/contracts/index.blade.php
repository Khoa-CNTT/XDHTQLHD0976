@extends('layouts.customer')

@section('title', 'Hợp Đồng Của Tôi')
<!-- Thêm SweetAlert2 từ CDN vào phần <head> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Kiểm tra và hiển thị thông báo nếu có -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#111827',
                    iconColor: '#22c55e',  
                    customClass: {
                        popup: 'rounded-md shadow-md px-4 py-2 text-sm'  
                    }
                }).then(function() {
                // Reload lại trang sau khi thông báo hiển thị
                location.reload();  // Reload lại trang
                });
            });
        </script>
    @endif
    
@section('content')
<div class="max-w-4xl mx-auto min-h-screen pb-20">
    <h1 class="text-4xl font-bold mb-8 text-center mt-8 text-black">
        Hợp Đồng Của Tôi
    </h1>

    <!-- Danh Sách Hợp Đồng -->
    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-100 mb-16">
        <h2 class="text-xl font-semibold mb-6">Danh Sách Hợp Đồng</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-left px-3 py-1 text-sm">
                        <th class="p-3 w-48">Tên Dịch Vụ</th>
                        <th class="p-3 w-40">Ngày Ký Hợp Đồng</th>
                        <th class="p-3 w-40">Trạng Thái</th>
                        <th class="p-3 w-60 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contracts as $contract)
                        <tr class="border-b">
                            <td class="p-3">
                                @if($contract->service)
                                    {{ $contract->service->service_name }}
                                @else
                                    <span class="text-red-500">Dịch vụ không tồn tại</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $contract->start_date }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-sm inline-block
                                    @if ($contract->status === 'Chờ xử lý') bg-yellow-100 text-yellow-600
                                    @elseif ($contract->status === 'Hoạt động') bg-green-100 text-green-600
                                    @elseif ($contract->status === 'Hoàn thành') bg-blue-100 text-blue-600
                                    @elseif ($contract->status === 'Đã huỷ') bg-red-100 text-red-600
                                    @endif">
                                    {{ $contract->status }}
                                </span>
                            </td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('customer.contracts.show', $contract->id) }}"
                                   class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg w-24 h-10 text-sm">
                                    📄 <span class="ml-1">Xem</span>
                                </a>
                            
                                @if ($contract->status !== 'Đã huỷ' && $contract->status !== 'Yêu cầu huỷ')
                                    <form action="{{ route('customer.contracts.requestCancel', $contract->id) }}" method="POST" class="inline-flex">
                                        @csrf
                                        <button type="submit"
                                                class="flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg w-24 h-10 text-sm">
                                            ❌ <span class="ml-1">Yêu cầu huỷ</span>
                                        </button>
                                    </form>
                                @elseif($contract->status === 'Yêu cầu huỷ')
                                    <span class="text-red-500 font-semibold ml-2">Đã gửi yêu cầu huỷ</span>
                                @endif
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Không có hợp đồng nào.</p>
                                    <p class="text-gray-400 mt-2">Khi bạn đăng ký dịch vụ, hợp đồng sẽ xuất hiện ở đây.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Thêm phần giới thiệu hoặc thông tin hữu ích -->
    <div class="bg-blue-50 rounded-lg p-6 border border-blue-100 mb-20">
        <h3 class="text-lg font-semibold mb-2 text-blue-800">Thông tin về hợp đồng</h3>
        <p class="text-gray-600 mb-4">Hợp đồng của bạn được quản lý tại đây. Bạn có thể xem chi tiết hoặc gửi yêu cầu hủy khi cần thiết.</p>
        <div class="flex space-x-1">
            <div class="flex items-center space-x-1">
                <span class="inline-block w-3 h-3 rounded-full bg-yellow-100 border border-yellow-600"></span>
                <span class="text-sm text-gray-600">Chờ xử lý</span>
            </div>
            <div class="mx-2 text-gray-300">|</div>
            <div class="flex items-center space-x-1">
                <span class="inline-block w-3 h-3 rounded-full bg-green-100 border border-green-600"></span>
                <span class="text-sm text-gray-600">Hoạt động</span>
            </div>
            <div class="mx-2 text-gray-300">|</div>
            <div class="flex items-center space-x-1">
                <span class="inline-block w-3 h-3 rounded-full bg-blue-100 border border-blue-600"></span>
                <span class="text-sm text-gray-600">Hoàn thành</span>
            </div>
            <div class="mx-2 text-gray-300">|</div>
            <div class="flex items-center space-x-1">
                <span class="inline-block w-3 h-3 rounded-full bg-red-100 border border-red-600"></span>
                <span class="text-sm text-gray-600">Đã huỷ</span>
            </div>
        </div>
    </div>
</div>
@endsection