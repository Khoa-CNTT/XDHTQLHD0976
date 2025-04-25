@extends('layouts.customer')

@section('title', 'Hợp Đồng Của Tôi')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold mb-8 text-center mt-2 text-black">
        Hợp Đồng Của Tôi
    </h1>

    <!-- Danh Sách Hợp Đồng -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Danh Sách Hợp Đồng</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-left px-3 py-1 text-sm">
                        <th class="p-3 w-48">Tên Dịch Vụ</th>
                        <th class="p-3 w-40">Ngày Ký Hợp Đồng</th>
                        <th class="p-3 w-40">Trạng Thái</th>
                        <th class="p-3 w-60 text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contracts as $contract)
                        <tr class="border-b">
                            <td class="p-3">{{ $contract->service->service_name }}</td>
                            <td class="p-3">{{ $contract->start_date }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-sm inline-block
                                    @if ($contract->status === 'Chờ xử lý') bg-yellow-100 text-yellow-600
                                    @elseif ($contract->status === 'Hoạt động') bg-green-100 text-green-600
                                    @elseif ($contract->status === 'Hoàn thành') bg-blue-100 text-blue-600
                                    @elseif ($contract->status === 'Đã huỷ') bg-red-100 text-red-600
                                    @endif">
                                    {{ $contract->status }}
                                </span>
                            </td>
                            <td class="p-3 flex space-x-2">
                                <a href="{{ route('customer.contracts.show', $contract->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                                    📄 <span class="ml-1">Xem</span>
                                </a>
                                @if ($contract->status !== 'Đã huỷ')
                                    <form action="" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                                            ❌ <span class="ml-1">Hủy</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-3 text-center text-gray-500">Không có hợp đồng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection