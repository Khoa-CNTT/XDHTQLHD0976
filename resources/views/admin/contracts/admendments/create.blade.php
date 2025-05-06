@extends('layouts.admin')

@section('title', 'Thêm Phụ Lục Hợp Đồng')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Thêm Phụ Lục Hợp Đồng: {{ $contract->contract_number }}</h2>

    <form action="{{ route('admin.contracts.amendments.store', $contract->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="amendment_reason" class="block text-sm font-medium text-gray-700">Lý Do</label>
            <textarea name="amendment_reason" id="amendment_reason" class="border rounded px-4 py-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label for="changes_made" class="block text-sm font-medium text-gray-700">Chi Tiết</label>
            <textarea name="changes_made" id="changes_made" class="border rounded px-4 py-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label for="effective_date" class="block text-sm font-medium text-gray-700">Ngày Hiệu Lực</label>
            <input type="date" name="effective_date" id="effective_date" class="border rounded px-4 py-2 w-full" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu</button>
    </form>
</div>
@endsection