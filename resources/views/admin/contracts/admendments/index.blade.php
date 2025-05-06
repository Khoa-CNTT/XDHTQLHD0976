@extends('layouts.admin')

@section('title', 'Phụ Lục Hợp Đồng')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Phụ Lục Hợp Đồng: {{ $contract->contract_number }}</h2>

    <a href="{{ route('admin.contracts.admendments.create', $contract->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Thêm Phụ Lục</a>

    <div class="overflow-x-auto bg-white p-4 shadow-xl rounded-xl border border-gray-300">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Lý Do</th>
                    <th class="py-3 px-6 text-left">Chi Tiết</th>
                    <th class="py-3 px-6 text-left">Ngày Hiệu Lực</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contract->amendments as $amendment)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $amendment->amendment_reason }}</td>
                    <td class="py-3 px-6">{{ $amendment->changes_made }}</td>
                    <td class="py-3 px-6">{{ $amendment->effective_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection