@extends('layouts.admin')
@section('title', 'Quản lý thời hạn dịch vụ')

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

@if(session()->has('error'))
    @push('scripts')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    </script>
    @endpush
@endif

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Quản lý thời hạn dịch vụ</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.services.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
            <a href="{{ route('admin.durations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i> Thêm thời hạn mới
            </a>
            <a href="{{ route('admin.durations.price-config') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-money-bill mr-2"></i> Thiết lập giá
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            @if($durations->count() > 0)
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Tên thời hạn</th>
                        <th class="py-3 px-6 text-center">Số tháng</th>
                        <th class="py-3 px-6 text-center">Ngày tạo</th>
                        <th class="py-3 px-6 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($durations as $duration)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $duration->id }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $duration->label }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            {{ $duration->months }} tháng
                        </td>
                        <td class="py-3 px-6 text-center">
                            {{ $duration->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.durations.edit', $duration->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                    Sửa
                                </a>
                                <form action="{{ route('admin.durations.destroy', $duration->id) }}"
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
                <p class="text-gray-700 font-medium text-lg">Chưa có thời hạn nào được thiết lập</p>
                <p class="text-gray-500 mt-2">Hãy thêm thời hạn dịch vụ mới</p>
                <a href="{{ route('admin.durations.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Thêm thời hạn mới
                </a>
            </div>
            @endif
        </div>
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