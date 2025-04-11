@extends('layouts.admin')
@section('title', 'Chi tiết dịch vụ')

@section('content')
<div class="max-w-4xl mx-auto mt-12 p-8 bg-white rounded-2xl shadow-xl border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Chi tiết dịch vụ</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[17px] text-gray-700 leading-relaxed">
        <div class="space-y-3">
            <div>
                <div class="text-gray-500 text-sm">Tên dịch vụ</div>
                <div class="font-medium text-gray-900">{{ $service->service_name }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Mô tả</div>
                <div class="text-gray-900">{{ $service->description }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Nội dung chi tiết</div>
                <div class="text-gray-900">{{ $service->content }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Giá</div>
                <div class="font-semibold text-gray-900">{{ number_format($service->price, 0, ',', '.') }} VND</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Sản phẩm hot</div>
                <div class="text-gray-900">
                    @if ($service->is_hot)
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-600 font-semibold rounded-full text-sm">HOT 🔥</span>
                    @else
                        <span class="text-gray-500">Không</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <div class="text-gray-500 text-sm">Loại dịch vụ</div>
                <div class="text-gray-900">{{ $service->service_type }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Người tạo</div>
                <div class="text-gray-900">{{ $service->employee->name ?? 'Admin' }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Ngày tạo</div>
                <div class="text-gray-900">{{ $service->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Cập nhật lần cuối</div>
                <div class="text-gray-900">{{ $service->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
    <div class="mt-6 text-right">
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Trở lại</a>
    </div>
</div>
@endsection
