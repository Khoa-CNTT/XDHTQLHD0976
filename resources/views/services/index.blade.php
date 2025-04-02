@extends('layouts.dashboard')

@section('title', 'Danh sách Dịch vụ')

@push('styles')
<style>
  table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: white; }
  th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
  th { background: #4a5568; color: white; }
  .action-links a { margin-right: 10px; text-decoration: none; font-weight: bold; }
  .btn { background: #667eea; color: white; padding: 10px; border-radius: 5px; text-decoration: none; }
  .btn:hover { background: #5a67d8; }
  .message { padding: 10px; background: #48bb78; color: white; border-radius: 5px; margin-bottom: 10px; }
</style>
@endpush

@section('content')
  <div class="service-container">
    <h1>Danh sách Dịch vụ</h1>
    @if(session('success'))
      <div class="message">{{ session('success') }}</div>
    @endif
    @can('create', App\Models\Service::class)
      <a href="{{ route('services.create') }}" class="btn">➕ Tạo Dịch vụ Mới</a>
    @endcan
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên Dịch vụ</th>
          <th>Mô tả</th>
          <th>Giá</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $service)
          <tr>
            <td>{{ $service->id }}</td>
            <td>{{ $service->name }}</td>
            <td>{{ $service->description }}</td>
            <td>{{ $service->price }} <h6 style="color: red; ">VND</h6></td>
            <td>{{ $service->status }}</td>
            <td class="action-links">
              <a href="{{ route('services.show', $service) }}">🔍 Xem</a>
              @can('update', $service)
                <a href="{{ route('services.edit', $service) }}">✏️ Sửa</a>
              @endcan
              @can('delete', $service)
                <form action="{{ route('services.destroy', $service) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Xác nhận xóa?')">🗑️ Xóa</button>
                </form>
              @endcan
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === "created") {
            Swal.fire({
                title: "Thành công!",
                text: "Dịch vụ đã được tạo thành công!",
                icon: "success",
                confirmButtonText: "OK"
            });
        } else if (status === "updated") {
            Swal.fire({
                title: "Cập nhật thành công!",
                text: "Dịch vụ đã được cập nhật!",
                icon: "success",
                confirmButtonText: "OK"
            });
        } else if (status === "deleted") {
            Swal.fire({
                title: "Xóa thành công!",
                text: "Dịch vụ đã bị xóa!",
                icon: "success",
                confirmButtonText: "OK"
            });
        }
    });
</script>
@endpush
