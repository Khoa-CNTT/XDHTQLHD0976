@extends('layouts.admin')

@section('title', 'Danh Mục Dịch Vụ')

@if(session('success'))
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
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Danh Mục Dịch Vụ</h2>

    <form action="{{ route('admin.service-categories.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="flex items-center space-x-4">
            <input type="text" name="name" placeholder="Tên danh mục" class="border rounded px-4 py-2" required>
            <input type="text" name="description" placeholder="Mô tả" class="border rounded px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Thêm</button>
    
            <a href="{{ route('admin.services.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Trở lại</a>
        </div>
    
        @if ($errors->any())
            <div class="mt-2 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
    
    

    <div class="overflow-x-auto bg-white p-4 shadow-xl rounded-xl border border-gray-300">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tên</th>
                    <th class="py-3 px-6 text-left">Mô tả</th>
                    <th class="py-3 px-6 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($categories as $category)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        {{ $category->name }}
                    </td>
                    <td class="py-3 px-6 text-left max-w-xs truncate" title="{{ $category->description }}">
                        {{ $category->description }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('admin.service-categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition duration-200">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   
</div>
@endsection