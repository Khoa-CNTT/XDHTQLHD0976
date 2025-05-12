@extends('layouts.admin')
@section('title', 'Chỉnh sửa thời hạn')

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Chỉnh sửa thời hạn: {{ $duration->label }}</h2>
        <a href="{{ route('admin.durations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <form action="{{ route('admin.durations.update', $duration->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="label" class="block mb-2 text-sm font-medium text-gray-700">Tên thời hạn <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="label" 
                    name="label" 
                    value="{{ old('label', $duration->label) }}" 
                    class="w-full px-4 py-2 border @error('label') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    placeholder="Ví dụ: 6 tháng, 12 tháng, 24 tháng..."
                >
                @error('label')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="months" class="block mb-2 text-sm font-medium text-gray-700">Số tháng <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="months" 
                    name="months" 
                    value="{{ old('months', $duration->months) }}" 
                    class="w-full px-4 py-2 border @error('months') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    placeholder="Ví dụ: 6, 12, 24..."
                    min="1"
                >
                @error('months')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 font-medium">
                    <i class="fas fa-save mr-2"></i> Cập nhật thời hạn
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 