{{-- filepath: resources/views/admin/services/show.blade.php --}}
@extends('layouts.admin')
@section('title', 'Chi tiết dịch vụ')

@section('content')
<div class="max-w-xl md:max-w-2xl lg:max-w-3xl mx-auto mt-10">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
            <h2 class="text-xl md:text-2xl font-bold text-blue-700 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>
                Chi tiết dịch vụ
            </h2>
            <a href="{{ route('admin.services.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center gap-2 text-xs md:text-sm">
                <i class="fas fa-arrow-left"></i>Quay lại
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Tên dịch vụ</div>
                    <div class="bg-gray-50 rounded px-2 py-1 font-semibold text-gray-900 border border-gray-100 text-sm">{{ $service->service_name }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Mô tả</div>
                    <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 text-sm">{{ $service->description }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Nội dung chi tiết</div>
                    <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 whitespace-pre-line text-sm">{{ $service->content }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Sản phẩm hot</div>
                    @if ($service->is_hot)
                        <span class="inline-block px-2 py-1 bg-red-100 text-red-600 font-semibold rounded-full text-xs">HOT 🔥</span>
                    @else
                        <span class="text-gray-500 text-xs">Không</span>
                    @endif
                </div>
            </div>
            <div class="space-y-2">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Loại dịch vụ</div>
                    <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 text-sm">{{ $service->category->name ?? 'Không có danh mục' }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Người tạo</div>
                    <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 text-sm">
                        @if($service->employee && $service->employee->user)
                            {{ $service->employee->user->name }}
                        @else
                            Admin
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Ngày tạo</div>
                        <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 text-xs">{{ $service->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Cập nhật</div>
                        <div class="bg-gray-50 rounded px-2 py-1 text-gray-800 border border-gray-100 text-xs">{{ $service->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bảng thời hạn & giá --}}
        <div class="mt-6 bg-gray-50 rounded-xl border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-bold text-purple-700 flex items-center gap-2">
                    <i class="fas fa-clock text-purple-500"></i>
                    Thời hạn & Giá dịch vụ
                </h3>
                <a href="{{ route('admin.services.contract-durations.edit', $service->id) }}" class="px-2 py-1 bg-purple-500 text-white rounded hover:bg-purple-600 text-xs flex items-center gap-2">
                    <i class="fas fa-edit"></i> Chỉnh sửa giá
                </a>
            </div>
            @php
                $contractDurations = $service->contractDurations()->with('duration')->orderBy('duration_id', 'asc')->get();
            @endphp
            @if($contractDurations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg text-xs">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-3 text-left text-gray-600 font-semibold">Thời hạn</th>
                                <th class="py-2 px-3 text-center text-gray-600 font-semibold">Số tháng</th>
                                <th class="py-2 px-3 text-right text-gray-600 font-semibold">Số tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($contractDurations as $contractDuration)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-3 text-left">{{ $contractDuration->duration->label }}</td>
                                    <td class="py-2 px-3 text-center">{{ $contractDuration->duration->months }}</td>
                                    <td class="py-2 px-3 text-right font-medium">{{ number_format($contractDuration->price, 0, '.', ',') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    Khách hàng sẽ thấy các thời hạn và giá tương ứng này khi xem chi tiết dịch vụ.
                </div>
            @else
                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                    <div>
                        <h3 class="text-xs font-medium text-yellow-800">Chưa thiết lập thời hạn</h3>
                        <p class="mt-1 text-xs text-yellow-700">Chưa có thời hạn nào được thiết lập cho dịch vụ này. Khách hàng sẽ chỉ thấy giá cơ bản của dịch vụ.</p>
                        <div class="mt-2">
                            <a href="{{ route('admin.services.contract-durations.edit', $service->id) }}" class="text-xs font-medium text-yellow-800 hover:text-yellow-600">
                                Thiết lập ngay <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Ảnh dịch vụ --}}
        <div class="mt-6">
            <div class="text-xs font-semibold text-gray-500 uppercase mb-2">Ảnh dịch vụ</div>
            @if ($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="w-full max-w-[180px] h-auto rounded-lg shadow-md border border-gray-200">
            @else
                <p class="text-gray-500 text-xs">Không có ảnh</p>
            @endif
        </div>
    </div>
</div>
@endsection