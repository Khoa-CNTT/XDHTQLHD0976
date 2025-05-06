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

    <div class="flex space-x-4">
        @can('create', App\Models\Contract::class)
            <a href="{{ route('admin.contracts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                Thêm hợp đồng mới
            </a>
        @endcan
    
        @foreach($contracts as $contract) 
        @can('create', App\Models\ContractAmendment::class)
            <a href="{{ route('admin.contracts.admendments.index', $contract->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                Phụ lục hợp đồng
            </a>
        @endcan
    @endforeach
    </div>

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
                            <form action="{{ route('admin.contracts.destroy', $contract->id) }}"
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
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('admin.contracts.updateStatus', $contract->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select text-sm px-2 py-1 rounded-lg border-gray-300">
                                <option value="Chờ xử lý" {{ $contract->status === 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="Hoạt động" {{ $contract->status === 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="Hoàn thành" {{ $contract->status === 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="Đã huỷ" {{ $contract->status === 'Đã huỷ' ? 'selected' : '' }}>Đã huỷ</option>
                            </select>
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                Cập nhật
                            </button>
                        </form>
                        <form action="{{ route('admin.contracts.complete', $contract->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Đánh dấu Hoàn thành
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contracts->links() }}
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
