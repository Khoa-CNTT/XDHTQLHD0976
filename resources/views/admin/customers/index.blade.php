@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

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
    <h2 class="text-2xl font-semibold mb-6">Danh sách Khách hàng</h2>

    <!-- Bộ lọc tìm kiếm -->
    <div class="bg-white p-4 shadow-md rounded-lg border border-gray-300 mb-6">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Tìm theo tên, email hoặc số điện thoại" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ request('search') }}">
            </div>
            
            <div class="md:w-1/4">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Đã bị khóa</option>
                </select>
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i> Tìm kiếm
                </button>
                
                <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i> Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Hiển thị kết quả tìm kiếm -->
    @if(request('search') || request('status'))
    <div class="mb-4 text-sm text-gray-600">
        Kết quả tìm kiếm {{ $customers->total() }} khách hàng
        @if(request('search'))
            với từ khóa: <span class="font-semibold">{{ request('search') }}</span>
        @endif
        @if(request('status'))
            có trạng thái: <span class="font-semibold">{{ request('status') == 'active' ? 'Đang hoạt động' : 'Đã bị khóa' }}</span>
        @endif
    </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-300">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Tên</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-center">Trạng thái</th>
                    <th class="px-4 py-3 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-light">
                @foreach($customers as $index => $customer)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3">{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $customer->name }}</td>
                    <td class="px-4 py-3">{{ $customer->email }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                            @if($customer->status == 'active') 
                                bg-green-100 text-green-800
                            @else 
                                bg-red-100 text-red-800 
                            @endif">
                            {{ $customer->status == 'active' ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($customer->status == 'active')
                            <form action="{{ route('admin.customers.ban', $customer->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                    Khóa
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.customers.unban', $customer->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                    Mở khóa
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                Xóa
                            </button>
                        </form>                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $customers->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Ngăn form submit mặc định

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
                event.target.submit(); // Nếu xác nhận, thực hiện submit form
            }
        });
    }
</script>
@endpush