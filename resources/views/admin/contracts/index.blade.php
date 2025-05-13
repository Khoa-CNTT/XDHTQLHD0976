@extends('layouts.admin')
@section('title', 'Danh sách Hợp đồng')

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
    <h2 class="text-2xl font-semibold mb-6">Danh sách Hợp đồng</h2>

    <div class="flex flex-col md:flex-row md:justify-between mb-6 gap-4">
        <div>
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.contracts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Thêm hợp đồng mới
                </a>
                <a href="{{ route('admin.signature.form') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-signature mr-2"></i> Tải lên chữ ký tay
                </a>
            @endif
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm -->
    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-6">
        <form action="{{ route('admin.contracts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="contract_number" class="block text-sm font-medium text-gray-700 mb-1">Mã hợp đồng</label>
                <input type="text" id="contract_number" name="contract_number" value="{{ request('contract_number') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Nhập mã hợp đồng">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Chờ xử lý" {{ request('status') == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="Hoàn thành" {{ request('status') == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="Đã huỷ" {{ request('status') == 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                    <option value="Yêu cầu huỷ" {{ request('status') == 'Yêu cầu huỷ' ? 'selected' : '' }}>Yêu cầu huỷ</option>
                </select>
            </div>
            
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Dịch vụ</label>
                <select id="service_id" name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả dịch vụ</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Tên khách hàng</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ request('customer_name') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Tìm theo tên khách hàng">
            </div>
            
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="md:col-span-3 flex justify-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i> Tìm kiếm
                </button>
                
                <a href="{{ route('admin.contracts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i> Đặt lại
                </a>
            </div>
        </form>
    </div>
    
    <!-- Hiển thị kết quả tìm kiếm -->
    @if(request()->anyFilled(['contract_number', 'status', 'service_id', 'customer_name', 'date_from', 'date_to']))
    <div class="mb-4 text-sm text-gray-600">
        Kết quả tìm kiếm {{ $contracts->total() }} hợp đồng
        @if(request('contract_number'))
            với mã: <span class="font-semibold">{{ request('contract_number') }}</span>
        @endif
        @if(request('status'))
            có trạng thái: <span class="font-semibold">{{ request('status') }}</span>
        @endif
        @if(request('service_id'))
            thuộc dịch vụ: <span class="font-semibold">{{ $services->where('id', request('service_id'))->first()->service_name }}</span>
        @endif
    </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-xl rounded-xl border border-gray-300">

        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Mã hợp đồng</th>
                    <th class="py-3 px-6 text-left">Dịch vụ</th>
                    <th class="py-3 px-6 text-left">Khách hàng</th>
                    <th class="py-3 px-6 text-left">Trạng thái</th>
                    <th class="py-3 px-6 text-center">Hành động</th>
                    <th class="py-3 px-6 text-center"></th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @if($contracts->count() > 0)
                    @foreach($contracts as $contract)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $contract->contract_number }}</td>
                        <td class="py-3 px-6">{{ optional($contract->service)->service_name }}</td>
                        <td class="py-3 px-6">{{ optional($contract->customer)->name }}</td>
                        <td class="py-3 px-6">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                @switch($contract->status)
                                    @case('Hoạt động') bg-green-100 text-green-800 @break
                                    @case('Hoàn thành') bg-blue-100 text-blue-800 @break
                                    @case('Đã huỷ') bg-red-100 text-red-800 @break
                                    
                                    @default bg-yellow-100 text-yellow-800
                                @endswitch">
                                {{ $contract->status }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    Xem
                                </a>
                                <a href="{{ route('admin.contracts.edit', $contract->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    Sửa
                                </a>
                                @if(auth()->user()->role == 'admin')
                                <form action="{{ route('admin.contracts.destroy', $contract->id) }}"
                                    method="POST" onsubmit="confirmDelete(event)">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit"
                                          class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                      Xóa
                                  </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <form action="{{ route('admin.contracts.updateStatus', $contract->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select text-sm px-2 py-1 rounded-lg border-gray-300">
                                    <option value="Chờ xử lý" {{ $contract->status === 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="Hoàn thành" {{ $contract->status === 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="Đã huỷ" {{ $contract->status === 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                                </select>
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    Cập nhật
                                </button>
                            </form>
                            @if($contract->status !== 'Hoàn thành')
                            <form action="{{ route('admin.contracts.complete', $contract->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Đánh dấu Hoàn thành
                                </button>
                            </form>
                            @endif
                            @if($contract->status === 'Yêu cầu huỷ')
                            <form action="{{ route('admin.contracts.confirmCancel', $contract->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-xs font-medium px-3 py-1 rounded-lg transition duration-200">
                                    Xác nhận huỷ
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center">
                            <div class="text-gray-500">Không tìm thấy hợp đồng nào</div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contracts->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Hợp đồng này sẽ bị xóa và không thể khôi phục!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
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
