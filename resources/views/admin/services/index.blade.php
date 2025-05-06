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

    <a href="{{ route('admin.services.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Thêm dịch vụ mới
    </a>
    <a href="{{ route('admin.service-categories.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Quản lý loại dịch vụ
    </a>

    <div class="overflow-x-auto bg-white p-* shadow-xl rounded-xl border border-gray-300">

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
                        {{ $service->employee->name ?? 'Admin' }}
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
</script>
@endpush
