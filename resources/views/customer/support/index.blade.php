@extends('layouts.customer')

@section('title', 'Yêu cầu hỗ trợ của tôi')

@push('styles')
<style>
    .support-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(226, 232, 240, 1);
    }
    
    .support-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-color: rgba(66, 153, 225, 0.5);
    }
    
    .status-badge {
        transition: all 0.2s ease;
    }
    
    .status-badge:hover {
        transform: scale(1.05);
    }
    
    .action-button {
        transition: all 0.2s ease;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
    }
    
    .create-button {
        background: linear-gradient(to right, #3182ce, #2c5282);
        transition: all 0.3s ease;
    }
    
    .create-button:hover {
        background: linear-gradient(to right, #2c5282, #3182ce);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .empty-state {
        background: linear-gradient(135deg, #f6f9fc 0%, #edf2f7 100%);
    }
    
    .table-header {
        background: linear-gradient(to right, #2b6cb0, #3182ce);
        color: white;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Animation delay for table rows */
    .animate-row:nth-child(1) { animation-delay: 0.1s; }
    .animate-row:nth-child(2) { animation-delay: 0.2s; }
    .animate-row:nth-child(3) { animation-delay: 0.3s; }
    .animate-row:nth-child(4) { animation-delay: 0.4s; }
    .animate-row:nth-child(5) { animation-delay: 0.5s; }
</style>
@endpush

@section('content')
<!-- Banner hỗ trợ với form tìm kiếm -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12 relative overflow-hidden banner-container">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left text-white">
                <h1 class="text-4xl font-bold mb-4">Hỗ Trợ Khách Hàng</h1>
                <p class="text-blue-100 text-lg max-w-lg mb-6">
                    Quản lý, theo dõi và gửi các yêu cầu hỗ trợ về dịch vụ của bạn một cách dễ dàng và nhanh chóng.
                </p>
                <!-- Form tìm kiếm -->
                <form action="{{ route('customer.support.index') }}" method="GET" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-2 mt-2">
                    <div class="flex-grow">
                        <input type="text" name="search" placeholder="Tìm kiếm theo tiêu đề hoặc ID yêu cầu..." 
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

<div class="flex flex-col min-h-screen">
    <div class="container mx-auto mt-8 flex-grow px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Yêu cầu hỗ trợ của tôi</h2>
                <p class="text-gray-600 mt-1">Quản lý và theo dõi các yêu cầu hỗ trợ của bạn</p>
            </div>
            <button onclick="openCreateTicketModal()" 
        class="px-6 py-3 rounded-lg transition duration-300 flex items-center shadow-md text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tạo yêu cầu mới
            </button>
        </div>

        @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow animate-fade-in" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow animate-fade-in" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden mb-10">
            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="table-header">
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Tiêu đề</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Phản hồi</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Ngày tạo</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($tickets as $ticket)
                            <tr class="hover:bg-blue-50 transition-colors duration-200 ease-in-out animate-fade-in animate-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $ticket->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $ticket->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @switch($ticket->status)
                                            @case('Chờ xử lý')
                                                bg-yellow-100 text-yellow-800
                                                @break
                                            @case('Đang xử lý')
                                                bg-blue-100 text-blue-800
                                                @break
                                            @case('Đã giải quyết')
                                                bg-green-100 text-green-800
                                                @break
                                            @case('Đã huỷ')
                                                bg-red-100 text-red-800
                                                @break
                                            @default
                                                bg-gray-100 text-gray-800
                                        @endswitch">
                                        <svg class="w-3 h-3 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            @switch($ticket->status)
                                                @case('Chờ xử lý')
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    @break
                                                @case('Đang xử lý')
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                                    @break
                                                @case('Đã giải quyết')
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    @break
                                                @case('Đã huỷ')
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    @break
                                                @default
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            @endswitch
                                        </svg>
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($ticket->responses->count() > 0)
                                        <div class="flex flex-col items-center">
                                            <span class="text-blue-600 font-medium">{{ $ticket->responses->count() }} phản hồi</span>
                                            @if($ticket->hasStaffResponse())
                                                <span class="mt-1 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full flex items-center">
                                                    <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                                    </svg>
                                                    Đã có phản hồi
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500">Chưa có phản hồi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <span>{{ $ticket->created_at->format('d/m/Y') }}</span>
                                        <span class="text-gray-400">{{ $ticket->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('customer.support.show', $ticket->id) }}"
                                    class="action-button inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state flex flex-col items-center justify-center py-12 rounded-lg animate-fade-in">
                    <svg class="w-20 h-20 text-blue-400 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Bạn chưa có yêu cầu hỗ trợ nào</h3>
                    <p class="text-gray-500 mb-6 text-center max-w-md">Hãy tạo yêu cầu hỗ trợ mới nếu bạn cần giúp đỡ về dịch vụ hoặc có bất kỳ thắc mắc nào</p>
                    <button onclick="openCreateTicketModal()" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tạo yêu cầu mới
                    </button>
                </div>
            @endif
        </div>
        <!-- Thông tin hữu ích -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
                <div class="mb-4 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Hỗ trợ 24/7</h3>
                <p class="text-gray-600 text-sm">Đội ngũ hỗ trợ luôn sẵn sàng giúp bạn giải quyết mọi vấn đề liên quan đến dịch vụ.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
                <div class="mb-4 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Theo dõi trạng thái</h3>
                <p class="text-gray-600 text-sm">Bạn có thể theo dõi trạng thái xử lý và phản hồi cho từng yêu cầu hỗ trợ.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
                <div class="mb-4 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">Bảo mật thông tin</h3>
                <p class="text-gray-600 text-sm">Mọi thông tin và nội dung hỗ trợ đều được bảo mật tuyệt đối.</p>
            </div>
        </div>
        <!-- FAQ -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-10">
            <h2 class="text-xl font-semibold mb-6 text-gray-800">Câu hỏi thường gặp về hỗ trợ</h2>
            <div class="space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-medium text-gray-800 mb-2">Làm thế nào để gửi yêu cầu hỗ trợ?</h3>
                    <p class="text-gray-600 text-sm">Bạn chỉ cần nhấn nút "Tạo yêu cầu mới" và điền thông tin chi tiết về vấn đề bạn gặp phải.</p>
                </div>
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-medium text-gray-800 mb-2">Tôi sẽ nhận phản hồi trong bao lâu?</h3>
                    <p class="text-gray-600 text-sm">Đội ngũ hỗ trợ sẽ phản hồi trong vòng 24h làm việc kể từ khi nhận được yêu cầu của bạn.</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800 mb-2">Tôi có thể cập nhật thêm thông tin cho yêu cầu đã gửi không?</h3>
                    <p class="text-gray-600 text-sm">Bạn có thể vào chi tiết yêu cầu để gửi thêm thông tin hoặc trao đổi với nhân viên hỗ trợ.</p>
                </div>
            </div>
        </div>
        <!-- Phân trang -->
        @if($tickets->count() > 0)
        <div class="mt-4 pb-12">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal tạo yêu cầu hỗ trợ - đặt bên ngoài container -->
<div id="createTicketModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100] hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                Tạo yêu cầu hỗ trợ mới
            </h3>
            <button onclick="closeCreateTicketModal()" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('customer.support.create') }}" method="POST" class="px-6 py-4">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề</label>
                <input type="text" id="title" name="title" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                       placeholder="Nhập tiêu đề yêu cầu hỗ trợ">
            </div>
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
                <textarea id="content" name="content" rows="5" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                          placeholder="Mô tả chi tiết vấn đề bạn đang gặp phải..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCreateTicketModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Huỷ bỏ
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Gửi yêu cầu
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Script tạo yêu cầu hỗ trợ - cấu trúc lại để đảm bảo hoạt động
    document.addEventListener('DOMContentLoaded', function() {
        // Đảm bảo script chỉ chạy sau khi trang đã tải xong
        window.openCreateTicketModal = function() {
            const modal = document.getElementById('createTicketModal');
            const modalContent = document.getElementById('modalContent');
            
            if (modal && modalContent) {
                // Hiển thị modal
                modal.classList.remove('hidden');
                
                // Áp dụng animation sau một khoảng thời gian ngắn
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 50);
            } else {
                console.error('Modal elements not found!');
            }
        };
        
        window.closeCreateTicketModal = function() {
            const modal = document.getElementById('createTicketModal');
            const modalContent = document.getElementById('modalContent');
            
            if (modal && modalContent) {
                // Animation ẩn
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                
                // Ẩn modal sau khi animation kết thúc
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        };
        
        // Đóng modal khi click bên ngoài
        const createTicketModal = document.getElementById('createTicketModal');
        if (createTicketModal) {
            createTicketModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCreateTicketModal();
                }
            });
        }
    });
</script>
@endpush
@endsection 