@extends('layouts.admin')
@section('title', 'Danh sách dịch vụ')

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
    <h2 class="text-2xl font-semibold mb-6">Danh sách dịch vụ</h2>

    <div class="flex flex-col md:flex-row md:justify-between mb-6 gap-4">
        <div>
            <a href="{{ route('admin.services.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i> Thêm dịch vụ mới
            </a>
            <a href="{{ route('admin.service-categories.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-folder mr-2"></i> Quản lý loại dịch vụ
            </a>
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm -->
    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-6">
        <form action="{{ route('admin.services.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tên dịch vụ hoặc mô tả">
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                <select id="category_id" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="created_by" class="block text-sm font-medium text-gray-700 mb-1">Người tạo</label>
                <select id="created_by" name="created_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả người tạo</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('created_by') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="price_from" class="block text-sm font-medium text-gray-700 mb-1">Giá từ</label>
                <input type="text" id="price_from" name="price_from" value="{{ request('price_from') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Giá thấp nhất">
            </div>
            
            <div>
                <label for="price_to" class="block text-sm font-medium text-gray-700 mb-1">Đến giá</label>
                <input type="text" id="price_to" name="price_to" value="{{ request('price_to') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Giá cao nhất">
            </div>
            
            <div class="flex items-end">
                <div class="flex items-center mb-1">
                    <input type="checkbox" id="is_hot" name="is_hot" value="1" {{ request('is_hot') ? 'checked' : '' }} 
                           class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_hot" class="ml-2 block text-sm font-medium text-gray-700">Chỉ hiển thị dịch vụ nổi bật</label>
                </div>
            </div>
            
            <div class="md:col-span-3 flex justify-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i> Tìm kiếm
                </button>
                
                <a href="{{ route('admin.services.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i> Đặt lại
                </a>
            </div>
        </form>
    </div>
    
    <!-- Hiển thị kết quả tìm kiếm -->
    @if(request()->anyFilled(['search', 'category_id', 'created_by', 'price_from', 'price_to', 'is_hot']))
    <div class="mb-4 text-sm text-gray-600">
        Kết quả tìm kiếm {{ $services->total() }} dịch vụ
        @if(request('search'))
            với từ khóa: <span class="font-semibold">{{ request('search') }}</span>
        @endif
        @if(request('category_id'))
            thuộc danh mục: <span class="font-semibold">{{ $categories->where('id', request('category_id'))->first()->name }}</span>
        @endif
        @if(request('is_hot'))
            <span class="font-semibold text-orange-500">Dịch vụ nổi bật</span>
        @endif
    </div>
    @endif

    <div class="overflow-x-auto bg-white p-4 shadow-xl rounded-xl border border-gray-300">
        @if($services->count() > 0)
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tên dịch vụ</th>
                    <th class="py-3 px-6 text-left">Mô tả</th>
                    <th class="py-3 px-6 text-center">Giá</th>
                    <th class="py-3 px-6 text-center">Loại dịch vụ</th>
                    <th class="py-3 px-6 text-center">Người tạo</th>
                    <th class="py-3 px-6 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($services as $service)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $service->service_name }}
                        @if($service->is_hot)
                            <span class="ml-2 bg-orange-100 text-orange-800 text-xs font-medium px-2 py-0.5 rounded">HOT</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left max-w-xs truncate" title="{{ $service->description }}">
                        {{ $service->description }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $service->price ? number_format($service->price, 0, ',', '.') . ' VND' : 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{$service->category->name ?? 'Không có danh mục' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $service->employee->user->name ?? 'Admin' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.services.show', $service->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                Xem
                            </a>
                            <a href="{{ route('admin.services.edit', $service->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                Sửa
                            </a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                  method="POST" onsubmit="confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    Xóa
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <p class="text-gray-700 font-medium text-lg">Không tìm thấy dịch vụ nào</p>
            <p class="text-gray-500 mt-2">Thử thay đổi bộ lọc tìm kiếm hoặc đặt lại để xem tất cả dịch vụ</p>
            <a href="{{ route('admin.services.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Xem tất cả dịch vụ
            </a>
        </div>
        @endif
    </div>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $services->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Ngăn form submit
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

    // Định dạng giá tiền khi nhập
    document.addEventListener('DOMContentLoaded', function() {
        function formatMoney(input) {
            let value = input.value.replace(/\D/g, '');
            if (value) {
                value = parseInt(value, 10).toLocaleString('vi-VN');
            }
            input.value = value;
        }
        
        const priceFromInput = document.getElementById('price_from');
        const priceToInput = document.getElementById('price_to');
        
        if (priceFromInput) {
            priceFromInput.addEventListener('input', function() {
                formatMoney(this);
            });
            formatMoney(priceFromInput);
        }
        
        if (priceToInput) {
            priceToInput.addEventListener('input', function() {
                formatMoney(this);
            });
            formatMoney(priceToInput);
        }
    });
</script>
@endpush
