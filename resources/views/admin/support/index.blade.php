@extends('layouts.admin')

@section('title', 'Quản lý yêu cầu hỗ trợ')

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
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-6">Quản lý yêu cầu hỗ trợ</h2>

    <!-- Bộ lọc tìm kiếm -->
    <div class="bg-white p-4 shadow-md rounded-lg border border-gray-300 mb-6">
        <form action="{{ route('admin.support.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tiêu đề hoặc nội dung">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Đang xử lý" {{ request('status') == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="Đã giải quyết" {{ request('status') == 'Đã giải quyết' ? 'selected' : '' }}>Đã giải quyết</option>
                    <option value="Đã huỷ" {{ request('status') == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                </select>
            </div>
            
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Khách hàng</label>
                <select id="user_id" name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả khách hàng</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('user_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} ({{ $customer->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="md:col-span-3 flex justify-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i> Tìm kiếm
                </button>
                
                <a href="{{ route('admin.support.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i> Đặt lại
                </a>
            </div>
        </form>
    </div>
    
    <!-- Hiển thị kết quả tìm kiếm -->
    @if(request()->anyFilled(['search', 'status', 'user_id']))
    <div class="mb-4 text-sm text-gray-600">
        Kết quả tìm kiếm {{ $tickets->total() }} yêu cầu hỗ trợ
        @if(request('search'))
            với từ khóa: <span class="font-semibold">{{ request('search') }}</span>
        @endif
        @if(request('status'))
            có trạng thái: <span class="font-semibold">{{ request('status') }}</span>
        @endif
        @if(request('user_id'))
            @php $customerName = $customers->where('id', request('user_id'))->first()->name ?? 'Không xác định'; @endphp
            từ khách hàng: <span class="font-semibold">{{ $customerName }}</span>
        @endif
    </div>
    @endif

     <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-300">
        @if($tickets->count() > 0)
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Khách hàng</th>
                    <th class="px-4 py-3 text-left">Tiêu đề</th>
                    <th class="px-4 py-3 text-center">Trạng thái</th>
                    <th class="px-4 py-3 text-center">Ngày tạo</th>
                    <th class="px-4 py-3 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-light">
                @foreach($tickets as $ticket)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $ticket->id }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="mr-2">
                                <img class="w-8 h-8 rounded-full" src="{{ $ticket->user ? $ticket->user->getAvatarUrl() : 'https://ui-avatars.com/api/?name=Unknown' }}" alt="Avatar">
                            </div>
                            <div>
                                <div class="font-medium">{{ $ticket->user->name ?? 'Không xác định' }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
    <div class="font-medium truncate max-w-xs">{{ $ticket->title }}</div>
                        @if($ticket->has_new_customer_response)
                            <span class="inline-block ml-2 px-2 py-0.5 bg-red-500 text-white text-xs rounded-full align-middle">Phản hồi mới</span>
                        @endif
                        @if($ticket->responses->count() > 0)
                            <div class="text-xs text-blue-500 mt-1">
                                {{ $ticket->responses->count() }} phản hồi
                                <span class="ml-1">•</span>
                                <span class="text-gray-500">Cập nhật: {{ $ticket->responses->sortByDesc('created_at')->first()->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                            @switch($ticket->status)
                                @case('Chờ xử lý') bg-yellow-100 text-yellow-800 @break
                                @case('Đang xử lý') bg-blue-100 text-blue-800 @break
                                @case('Đã giải quyết') bg-green-100 text-green-800 @break
                                @case('Đã huỷ') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-xs text-gray-500">
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.support.show', $ticket->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-eye mr-1"></i> Xem chi tiết
                        </a>
                       
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="text-center py-10 text-gray-500">Không tìm thấy yêu cầu hỗ trợ nào</div>
        @endif
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $tickets->appends(request()->query())->links() }}
    </div>
</div>
@endsection 