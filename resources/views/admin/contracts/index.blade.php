@extends('layouts.admin')
@section('title', 'Quản lý Hợp đồng')
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
<style>
    /* Định dạng nút "Thêm Hợp đồng" */
    .btn-add-contract {
        background: #38a169; /* Màu xanh lá */
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        transition: background 0.3s;
        border: none;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .btn-add-contract:hover {
        background: #2f855a;
    }

    /* Định dạng bảng hợp đồng */
    .contract-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .contract-table th, .contract-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .contract-table th {
        background: #2d3748;
        color: white;
    }

    .contract-table tr:nth-child(even) {
        background: #f8f9fa;
    }

    /* Căn chỉnh nội dung */
    .contract-container {
        max-width: 1200px;
        margin: 20px auto;
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="contract-container">
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Quản lý Hợp đồng</h1>

    <!-- Nút Thêm Hợp Đồng -->
    @can('create', App\Models\Contract::class)
    <a href="{{ route('admin.contracts.create') }}" class="btn-add-contract">➕ Thêm Hợp đồng</a>
    @endcan
    <!-- Bảng Hợp Đồng -->
    <table class="contract-table">
        <thead>
            <tr>
                <th>Mã hợp đồng</th>
                <th>Dịch vụ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract->contract_number }}</td>
                <td>{{ $contract->service->service_name }}</td>
                <td>{{ $contract->status }}</td>
                <td>
                    <a href="{{ route('admin.contracts.show', $contract->id) }}" class="btn btn-sm btn-info">Xem</a>
                    <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa hợp đồng này?')">Xóa</button>
                    </form>
                    <script>
                        function confirmDelete(event) {
                            event.preventDefault(); // Ngăn form submit ngay lập tức
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
                                    event.target.submit(); // Submit form nếu người dùng xác nhận
                                }
                            });
                        }
                    </script>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $contracts->links() }}
    </div>
</div>
@endsection
