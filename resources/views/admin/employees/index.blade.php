@extends('layouts.admin')

@section('title', 'Quản lý nhân viên')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Danh sách nhân viên</h1>

    <a href="{{ route('admin.employees.create') }}" 
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mb-4 inline-block transition duration-200">
        Thêm nhân viên
    </a>

    <div class="overflow-x-auto bg-white p-* shadow-xl rounded-xl border border-gray-300">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
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
                        {{ $index + 1 }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $employee->user->name ?? 'Không xác định' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $employee->position }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $employee->department }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ number_format($employee->salary, 0, ',', '.') }} VND
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $employee->hired_date }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                Sửa
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirmDelete(event)">
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
