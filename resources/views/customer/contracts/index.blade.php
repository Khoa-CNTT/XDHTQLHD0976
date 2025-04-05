<!-- filepath: c:\Users\ASUS_TUF\Documents\QuanLyHopDong\ConT_management\resources\views\customer\contracts\index.blade.php -->
@extends('layouts.customer')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4">Danh Sách Hợp Đồng</h2>

    <!-- Danh sách hợp đồng -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Mã Hợp Đồng</th>
                    <th class="border border-gray-300 px-4 py-2">Dịch Vụ</th>
                    <th class="border border-gray-300 px-4 py-2">Ngày Bắt Đầu</th>
                    <th class="border border-gray-300 px-4 py-2">Ngày Kết Thúc</th>
                    <th class="border border-gray-300 px-4 py-2">Trạng Thái</th>
                    <th class="border border-gray-300 px-4 py-2">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">{{ $contract->contract_number }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $contract->service->service_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $contract->start_date }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $contract->end_date }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        @php
                            $now = \Carbon\Carbon::now();
                            $end = \Carbon\Carbon::parse($contract->end_date);
                            $diffDays = $now->diffInDays($end, false);
                        @endphp

                        @if($now->greaterThan($end))
                            <span class="text-red-600 font-semibold">Hết Hạn</span>
                        @elseif($diffDays <= 15)
                            <span class="text-yellow-600 font-semibold">Sắp Hết Hạn</span>
                        @else
                            <span class="text-green-600 font-semibold">Hiệu Lực</span>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('customer.contracts.show', $contract->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Xem</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">Bạn chưa có hợp đồng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection