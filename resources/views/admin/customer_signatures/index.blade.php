@extends('layouts.admin')
@section('title', 'Quản lý chữ ký khách hàng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Quản lý chữ ký khách hàng</h1>


   {{-- Form tìm kiếm --}}
<form method="GET" class="flex flex-col md:flex-row items-center gap-4 mb-6 bg-white p-4 rounded-lg shadow-md">
    {{-- Ô tìm kiếm --}}
    <div class="w-full md:flex-1">
        <input type="text" name="search" placeholder="Tìm theo tên, email, mã số thuế, số hợp đồng..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ request('search') }}">
    </div>

    {{-- Ô trạng thái --}}
    <div class="w-full md:w-1/4">
        <select name="signature_status"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Trạng thái chữ ký --</option>
            <option value="Đã ký" {{ request('signature_status') == 'Đã ký' ? 'selected' : '' }}>Đã ký</option>
            <option value="Đang xử lý" {{ request('signature_status') == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
        </select>
    </div>

    {{-- Nút Tìm kiếm --}}
    <div class="flex space-x-2">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-search mr-2"></i> Tìm kiếm
        </button>

        {{-- Nút Đặt lại --}}
        <a href="{{ route('admin.customer-signatures.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-sync-alt mr-2"></i> Đặt lại
        </a>
    </div>
</form>



    {{-- Danh sách khách hàng --}}
   <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">
                        Khách hàng
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Số lượng hợp đồng
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Số lượng chữ ký
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Thao tác
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($customer->user && $customer->user->avatar)
                                <img class="h-12 w-12 rounded-full" src="{{ asset('storage/' . $customer->user->avatar) }}" alt="{{ $customer->user->name }} avatar">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-lg text-gray-600">{{ substr($customer->user->name ?? 'U', 0, 1) }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $customer->user->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $customer->id }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->user->email ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->contracts->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                            $signatureCount = 0;
                            foreach($customer->contracts as $contract) {
                                $signatureCount += $contract->signatures->count();
                            }
                        @endphp
                        {{ $signatureCount }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.customer-signatures.show', $customer->id) }}" class="text-indigo-600 hover:text-indigo-900">Xem chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        Không có khách hàng nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection 