@extends('layouts.customer')

@section('title', 'Yêu cầu hỗ trợ của tôi')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="container mx-auto mt-8 flex-grow">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Yêu cầu hỗ trợ của tôi</h2>
            <button onclick="openCreateTicketModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i> Tạo yêu cầu mới
            </button>
        </div>

        @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg border border-gray-300 mb-6">
            @if($tickets->count() > 0)
            <table class="min-w-full leading-normal">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Tiêu đề</th>
                        <th class="px-4 py-3 text-center">Trạng thái</th>
                        <th class="px-4 py-3 text-center">Phản hồi</th>
                        <th class="px-4 py-3 text-center">Ngày tạo</th>
                        <th class="px-4 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-light">
                    @foreach($tickets as $ticket)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $ticket->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium truncate max-w-xs">{{ $ticket->title }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($ticket->content, 50) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
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
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($ticket->responses->count() > 0)
                                <span class="text-blue-500">{{ $ticket->responses->count() }} phản hồi</span>
                                @if($ticket->hasStaffResponse())
                                    <span class="ml-1 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Đã có phản hồi</span>
                                @endif
                            @else
                                <span class="text-gray-500">Chưa có phản hồi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-xs text-gray-500">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('customer.support.show', $ticket->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-eye mr-1"></i> Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-10">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-gray-700 font-medium text-lg">Bạn chưa có yêu cầu hỗ trợ nào</p>
                <p class="text-gray-500 mt-2">Hãy tạo yêu cầu hỗ trợ mới nếu bạn cần giúp đỡ</p>
                <button onclick="openCreateTicketModal()" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Tạo yêu cầu mới
                </button>
            </div>
            @endif
        </div>

        <!-- Phân trang -->
        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    </div>

    <!-- Modal tạo yêu cầu hỗ trợ -->
    <div id="createTicketModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Tạo yêu cầu hỗ trợ mới</h3>
                <button onclick="closeCreateTicketModal()" class="text-gray-400 hover:text-gray-600">
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nhập tiêu đề yêu cầu hỗ trợ">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
                    <textarea id="content" name="content" rows="5" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Mô tả chi tiết vấn đề bạn đang gặp phải..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeCreateTicketModal()" class="mr-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200">
                        Huỷ bỏ
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                        Gửi yêu cầu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openCreateTicketModal() {
        document.getElementById('createTicketModal').classList.remove('hidden');
    }
    
    function closeCreateTicketModal() {
        document.getElementById('createTicketModal').classList.add('hidden');
    }
</script>
@endpush
@endsection 