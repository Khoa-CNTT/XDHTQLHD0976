@extends('layouts.dashboard')

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
    <a href="{{ route('contracts.create') }}" class="btn-add-contract">➕ Thêm Hợp đồng</a>
    @endcan
    <!-- Bảng Hợp Đồng -->
    <table class="contract-table">
        <thead>
            <tr>
                <th>Số Hợp đồng</th>
                <th>Tiêu đề</th>
                <th>Ngày bắt đầu</th>
                <th>Số tiền</th>
                <th>Khách hàng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract->contract_number }}</td>
                <td>{{ $contract->title }}</td>
                <td>{{ $contract->start_date }}</td>
                <td>{{ number_format($contract->amount) }} VNĐ</td>
                <td>{{ $contract->customer->name }}</td>
                <td>
                    <a href="{{ route('contracts.show', $contract) }}" class="text-blue-500 hover:underline">Xem</a> |
                    <a href="{{ route('contracts.edit', $contract) }}" class="text-yellow-500 hover:underline">Sửa</a> |
                    <form action="{{ route('contracts.destroy', $contract) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $contracts->links() }}
    </div>
</div>
@endsection
