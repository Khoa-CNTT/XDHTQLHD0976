@extends('layouts.admin')
@section('title', 'Chi tiết dịch vụ')

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
                <div class="text-gray-900">{{ $service->category->name ?? 'Không có danh mục' }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Người tạo</div>
                <div class="text-gray-900">
                    @if($service->employee && $service->employee->user)
                        {{ $service->employee->user->name }}
                    @else
                        Admin
                    @endif
                </div>
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
    
    <!-- Hiển thị thời hạn và giá -->
    <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Thời hạn và giá dịch vụ</h3>
            <a href="{{ route('admin.services.contract-durations.edit', $service->id) }}" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 text-sm flex items-center">
                <i class="fas fa-edit mr-2"></i> Chỉnh sửa giá theo thời hạn
            </a>
        </div>
        
        @php
            $contractDurations = $service->contractDurations()->with('duration')->orderBy('price')->get();
        @endphp
        
        @if($contractDurations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-6 text-left text-gray-600 font-medium">Thời hạn</th>
                            <th class="py-3 px-6 text-center text-gray-600 font-medium">Số tháng</th>
                            <th class="py-3 px-6 text-center text-gray-600 font-medium">Số tiền </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($contractDurations as $contractDuration)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">{{ $contractDuration->duration->label }}</td>
                                <td class="py-3 px-6 text-center">{{ $contractDuration->duration->months }}</td>
                                <td class="py-3 px-6 text-right font-medium">{{ number_format($contractDuration->price, 0, '.', ',') }} VND</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i> 
                Khách hàng sẽ thấy các thời hạn và giá tương ứng này khi xem chi tiết dịch vụ.
            </div>
        @else
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Chưa thiết lập thời hạn</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Chưa có thời hạn nào được thiết lập cho dịch vụ này. Khách hàng sẽ chỉ thấy giá cơ bản của dịch vụ.</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.services.contract-durations.edit', $service->id) }}" class="text-sm font-medium text-yellow-800 hover:text-yellow-600">
                                Thiết lập ngay <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <div class="mt-6">
        <div class="text-gray-500 text-sm mb-2">Ảnh dịch vụ</div>
        @if ($service->image)
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="w-full h-auto rounded-lg shadow-md">
        @else
            <p class="text-gray-500">Không có ảnh</p>
        @endif
    </div>
    
    <div class="mt-6 text-right">
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i> Trở lại
        </a>
    </div>
</div>
@endsection
