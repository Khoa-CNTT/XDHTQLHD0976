@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

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
    <h1 class="text-2xl font-bold mb-4">Danh sách khách hàng</h1>
    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Tên</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Trạng thái</th>
                <th class="px-4 py-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $customer->name }}</td>
                    <td class="border px-4 py-2">{{ $customer->email }}</td>
                    <td class="border px-4 py-2">
                        <span class="px-2 py-1 rounded {{ $customer->status == 'active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            {{ $customer->status == 'active' ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">
                        @if($customer->status == 'active')
                            <form action="{{ route('admin.customers.ban', $customer->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">Khóa</button>
                            </form>
                        @else
                            <form action="{{ route('admin.customers.unban', $customer->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Mở khóa</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
@push('scripts')
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Ngăn form submit
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
    @endpush