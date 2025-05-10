@extends('layouts.admin')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Danh sách nhân viên</h1>

    <!-- Nút thêm và bộ lọc tìm kiếm -->
    <div class="flex flex-col md:flex-row md:justify-between mb-6 gap-4">
        <!-- Nút thêm mới -->
        <div>
            <a href="{{ route('admin.employees.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mb-4 inline-block transition duration-200">
                <i class="fas fa-plus mr-2"></i> Thêm nhân viên
            </a>
        </div>

        <!-- Bộ lọc tìm kiếm -->
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200 w-full md:w-auto">
            <form action="{{ route('admin.employees.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Tìm theo tên, email hoặc chức vụ" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ request('search') }}">
                </div>
                
                <div class="flex-1">
                    <select name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả phòng ban</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->department }}" {{ request('department') == $dept->department ? 'selected' : '' }}>
                                {{ $dept->department }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-search mr-2"></i> Tìm kiếm
                    </button>
                    
                    <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-sync-alt mr-2"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Hiển thị kết quả tìm kiếm -->
    @if(request('search') || request('department'))
    <div class="mb-4 text-sm text-gray-600">
        Kết quả tìm kiếm {{ $employees->total() }} nhân viên
        @if(request('search'))
            với từ khóa: <span class="font-semibold">{{ request('search') }}</span>
        @endif
        @if(request('department'))
            thuộc phòng ban: <span class="font-semibold">{{ request('department') }}</span>
        @endif
    </div>
    @endif

    <!-- Bảng nhân viên -->
    <div class="overflow-x-auto bg-white p-4 shadow-xl rounded-xl border border-gray-300">
        @if($employees->count() > 0)
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">STT</th>
                    <th class="py-3 px-6 text-left">Người dùng</th>
                    <th class="py-3 px-6 text-center">Chức vụ</th>
                    <th class="py-3 px-6 text-center">Phòng ban</th>
                    <th class="py-3 px-6 text-center">Lương</th>
                    <th class="py-3 px-6 text-center">Ngày vào làm</th>
                    <th class="py-3 px-6 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @foreach($employees as $index => $employee)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ ($employees->currentPage() - 1) * $employees->perPage() + $index + 1 }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <div class="mr-2">
                                <img class="w-8 h-8 rounded-full" src="{{ $employee->user->getAvatarUrl() }}" alt="Avatar">
                            </div>
                            <div>
                                <div class="font-medium">{{ $employee->user->name ?? 'Không xác định' }}</div>
                                <div class="text-xs text-gray-500">{{ $employee->user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $employee->user->phone }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $employee->position }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                            {{ $employee->department }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ number_format($employee->salary, 0, ',', '.') }} VND
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ \Carbon\Carbon::parse($employee->hired_date)->format('d/m/Y') }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-edit mr-1"></i> Sửa
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    <i class="fas fa-trash mr-1"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-10">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8v1m0 0v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8a2.99 2.99 0 01-2.599-1.5h5.198M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-gray-700 font-medium text-lg">Không tìm thấy nhân viên nào</p>
            @if(request('search') || request('department'))
            <p class="text-gray-500 mt-2">Thử thay đổi bộ lọc tìm kiếm hoặc đặt lại để xem tất cả nhân viên</p>
            <a href="{{ route('admin.employees.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Xem tất cả nhân viên
            </a>
            @endif
        </div>
        @endif
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $employees->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endpush
