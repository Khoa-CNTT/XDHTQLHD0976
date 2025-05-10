@extends('layouts.admin')

@section('title', 'Quản lý thông báo')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý thông báo</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.notifications.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tạo thông báo mới
            </a>
            <a href="{{ route('admin.notifications.mass-create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Gửi thông báo hàng loạt
            </a>
            <form id="delete-all-form" action="{{ route('admin.notifications.destroyAll') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <!-- Hidden fields to carry over filter params -->
                <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                <input type="hidden" name="is_read" value="{{ request('is_read') }}">
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa tất cả {{ request()->hasAny(['user_id', 'is_read', 'date_from', 'date_to', 'search']) ? 'đã lọc' : '' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold text-gray-700">Bộ lọc thông báo</h2>
            <button id="toggle-filter" class="text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
        <div id="filter-form" class="mt-2">
            <form action="{{ route('admin.notifications.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Người nhận</label>
                    <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Tất cả</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="is_read" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="is_read" id="is_read" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('is_read') == '1' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="0" {{ request('is_read') == '0' ? 'selected' : '' }}>Chưa đọc</option>
                    </select>
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div class="md:col-span-2 lg:col-span-3">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Tìm kiếm theo tiêu đề hoặc nội dung..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Ẩn thông báo kiểu cũ và sử dụng SweetAlert thay thế -->
    @if(session('status'))
    <div class="hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('status') }}</p>
    </div>
    @endif

    @if(session('warning'))
    <div class="hidden bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
        <p>{{ session('warning') }}</p>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Người nhận</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Tiêu đề</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nội dung</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Trạng thái</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Ngày tạo</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($notifications as $notification)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 whitespace-nowrap">{{ $notification->id }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-800 font-bold">{{ substr($notification->user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $notification->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $notification->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">{{ $notification->title }}</td>
                    <td class="py-3 px-4">
                        <span class="text-sm text-gray-600">{{ Str::limit($notification->message, 50) }}</span>
                    </td>
                    <td class="py-3 px-4">
                        @if ($notification->is_read)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Đã đọc
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Chưa đọc
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $notification->created_at->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $notification->created_at->format('H:i') }}</div>
                    </td>
                    <td class="py-3 px-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="inline delete-notification-form">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" class="notification-id" value="{{ $notification->id }}">
                            <button type="submit" class="text-red-600 hover:text-red-800 bg-red-100 hover:bg-red-200 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-lg">Không có thông báo nào</p>
                            <p class="text-sm text-gray-500 mt-1">Tạo thông báo mới để gửi cho khách hàng</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $notifications->appends(request()->query())->links() }}
    </div>
</div>

<!-- Import SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilter = document.getElementById('toggle-filter');
        const filterForm = document.getElementById('filter-form');
        
        toggleFilter.addEventListener('click', function() {
            filterForm.classList.toggle('hidden');
            // Toggle the icon between down and up arrow
            const svg = this.querySelector('svg');
            if (filterForm.classList.contains('hidden')) {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
            } else {
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
            }
        });
        
        // Xử lý nút xóa tất cả
        const deleteAllForm = document.getElementById('delete-all-form');
        if (deleteAllForm) {
            deleteAllForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa tất cả thông báo đã lọc? Hành động này không thể hoàn tác!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xác nhận xóa',
                    cancelButtonText: 'Hủy bỏ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gửi request bằng fetch API
                        fetch('{{ route("admin.notifications.destroyAll") }}', {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Đã xóa thành công tất cả thông báo.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    // Reload trang để hiển thị kết quả
                                    window.location.reload();
                                });
                            } else {
                                throw new Error('Lỗi khi xóa thông báo');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi xóa thông báo.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6'
                            });
                        });
                    }
                });
            });
        }
        
        // Xử lý các nút xóa đơn lẻ
        const deleteButtons = document.querySelectorAll('.delete-notification-form');
        deleteButtons.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const notificationId = this.querySelector('.notification-id').value;
                
                Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa thông báo này? Hành động này không thể hoàn tác!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xác nhận xóa',
                    cancelButtonText: 'Hủy bỏ'
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                        const formAction = this.getAttribute('action');
                        
                        // Gửi request xóa
                        fetch(formAction, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Đã xóa thông báo thành công.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    // Reload trang hoặc xóa hàng khỏi bảng
                                    window.location.reload();
                                });
                            } else {
                                throw new Error('Lỗi khi xóa thông báo');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi xóa thông báo.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6'
                            });
                        });
                    }
                });
            });
        });
        
        // Hiển thị thông báo từ session nếu có
        @if(session('status'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        
        @if(session('warning'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: '{{ session('warning') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    });
</script>
@endsection 