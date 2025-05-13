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
<!-- Banner hợp đồng với form tìm kiếm -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12 relative overflow-hidden banner-container">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left text-white">
                <h1 class="text-4xl font-bold mb-4">Quản Lý Hợp Đồng</h1>
                <p class="text-blue-100 text-lg max-w-lg mb-6">
                    Xem, quản lý và theo dõi tất cả các hợp đồng của bạn một cách dễ dàng từ một nơi duy nhất.
                </p>
                
                <!-- Form tìm kiếm -->
                <form action="{{ route('customer.contracts.index') }}" method="GET" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-2 mt-2">
                    <div class="flex-grow">
                        <input type="text" name="search" placeholder="Tìm kiếm theo tên dịch vụ hoặc ID hợp đồng..." 
                            class="w-full px-4 py-2 rounded-lg border-0 focus:ring-2 focus:ring-blue-300 text-gray-700" 
                            value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors">
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
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tổng hợp đồng</p>
                <p class="text-2xl font-bold text-gray-800">{{ $contracts->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-green-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Đang hoạt động</p>
                <p class="text-2xl font-bold text-gray-800">{{ $contracts->where('status', 'Hoạt động')->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Chờ xử lý</p>
                <p class="text-2xl font-bold text-gray-800">{{ $contracts->where('status', 'Chờ xử lý')->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center hover:shadow-md transition">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Hoàn thành</p>
                <p class="text-2xl font-bold text-gray-800">{{ $contracts->where('status', 'Hoàn thành')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Danh Sách Hợp Đồng -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Danh Sách Hợp Đồng</h2>
            <div class="flex items-center space-x-1 text-xs text-gray-500">
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-yellow-100 border border-yellow-600 mr-1"></span>
                    <span>Chờ xử lý</span>
                </div>
                <div class="mx-1">|</div>
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-green-100 border border-green-600 mr-1"></span>
                    <span>Hoạt động</span>
                </div>
                <div class="mx-1">|</div>
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-blue-100 border border-blue-600 mr-1"></span>
                    <span>Hoàn thành</span>
                </div>
                <div class="mx-1">|</div>
                <div class="flex items-center px-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-red-100 border border-red-600 mr-1"></span>
                    <span>Đã huỷ</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-left">
                        <th class="p-3 font-medium">Tên Dịch Vụ</th>
                        <th class="p-3 font-medium">Ngày Ký Hợp Đồng</th>
                        <th class="p-3 font-medium">Trạng Thái</th>
                        <th class="p-3 font-medium text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contracts as $contract)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="p-3">
                                @if($contract->service)
                                    <div class="font-medium text-gray-800">{{ $contract->service->service_name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $contract->id }}</div>
                                @else
                                    <span class="text-red-500">Dịch vụ không tồn tại</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="font-medium text-gray-800">{{ date('d/m/Y', strtotime($contract->start_date)) }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($contract->start_date)->diffForHumans() }}</div>
                            </td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium inline-block
                                    @if ($contract->status === 'Chờ xử lý') bg-yellow-100 text-yellow-600
                                    @elseif ($contract->status === 'Hoàn thành') bg-blue-100 text-blue-600
                                    @elseif ($contract->status === 'Đã huỷ') bg-red-100 text-red-600
                                    @endif">
                                    {{ $contract->status }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex flex-col sm:flex-row items-center justify-center sm:space-x-3 space-y-2 sm:space-y-0">
                                    <a href="{{ route('customer.contracts.show', $contract->id) }}"
                                       class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg w-32 h-9 text-sm transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Xem chi tiết
                                    </a>
                                
                                    @if ($contract->status !== 'Đã huỷ' && $contract->status !== 'Yêu cầu huỷ')
                                        <form action="{{ route('customer.contracts.requestCancel', $contract->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg w-32 h-9 text-sm transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Yêu cầu huỷ
                                            </button>
                                        </form>
                                    @elseif($contract->status === 'Yêu cầu huỷ')
                                        <div class="flex items-center justify-center text-red-500 font-medium text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Đã gửi yêu cầu huỷ
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center">
                                <div class="flex flex-col items-center py-10">
                                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No contracts" class="w-32 h-32 mb-4 opacity-60">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có hợp đồng nào</h3>
                                    <p class="text-gray-500 mb-6 max-w-md text-center">Bạn chưa có hợp đồng nào. Hãy khám phá các dịch vụ của chúng tôi và bắt đầu đăng ký ngay.</p>
                                    <a href="{{ route('customer.services.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                        Khám phá dịch vụ
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Thông tin hữu ích -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Bảo mật thông tin</h3>
            <p class="text-gray-600 text-sm">Thông tin hợp đồng của bạn được bảo mật và mã hóa theo chuẩn ngành công nghiệp.</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Quản lý hợp đồng dễ dàng</h3>
            <p class="text-gray-600 text-sm">Xem, kiểm tra và quản lý tất cả hợp đồng của bạn từ một giao diện thống nhất.</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <div class="mb-4 text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Hỗ trợ 24/7</h3>
            <p class="text-gray-600 text-sm">Đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng giúp đỡ bạn với mọi vấn đề liên quan đến hợp đồng.</p>
        </div>
    </div>
    
    <!-- FAQ -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-10">
        <h2 class="text-xl font-semibold mb-6 text-gray-800">Câu hỏi thường gặp</h2>
        
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="font-medium text-gray-800 mb-2">Làm thế nào để yêu cầu hủy hợp đồng?</h3>
                <p class="text-gray-600 text-sm">Bạn có thể yêu cầu hủy hợp đồng bằng cách nhấn vào nút "Yêu cầu hủy" bên cạnh mỗi hợp đồng. Yêu cầu của bạn sẽ được xử lý trong vòng 24-48 giờ làm việc.</p>
            </div>
            
            <div class="border-b border-gray-100 pb-4">
                <h3 class="font-medium text-gray-800 mb-2">Tôi có thể gia hạn hợp đồng bằng cách nào?</h3>
                <p class="text-gray-600 text-sm">Để gia hạn hợp đồng, bạn có thể liên hệ với bộ phận hỗ trợ khách hàng của chúng tôi hoặc đợi thông báo gia hạn được gửi đến email của bạn trước khi hợp đồng hết hạn.</p>
            </div>
            
            <div>
                <h3 class="font-medium text-gray-800 mb-2">Tôi có thể thay đổi nội dung hợp đồng sau khi đã ký không?</h3>
                <p class="text-gray-600 text-sm">Sau khi hợp đồng đã được ký, bạn không thể thay đổi nội dung hợp đồng. Tuy nhiên, bạn có thể liên hệ với chúng tôi để thảo luận về các điều chỉnh cần thiết.</p>
            </div>
        </div>
    </div>
</div>
@endsection