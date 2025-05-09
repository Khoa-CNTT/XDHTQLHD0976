<!DOCTYPE html>
<html lang="vi">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta charset="UTF-8">
  <title>@yield('title', 'Admin')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  @stack('styles')
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, html { font-family: 'Roboto', sans-serif; background: #f4f7f9; color: #333; }
    header { background: #3d82e4; padding: 1rem 2rem; color: #fff; display: flex; justify-content: space-between; align-items: center; }
    .dashboard-container { display: flex; min-height: calc(100vh - 70px); }
    .sidebar { width: 250px; background: #111827; color: #fff; padding: 1.5rem 1rem; }
    .sidebar a { color: #cbd5e0; text-decoration: none; display: block; padding: 0.6rem; border-radius: 4px; transition: background 0.3s; }
    .sidebar a:hover { background: #374151; color: #fff; }
    .content { flex: 1; padding: 2rem; background: #fff; overflow-y: auto; }
    .btn-logout { background: #ef4444; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s; }
    .btn-logout:hover { background: #dc2626; }
  </style>
  @stack('styles')
</head>
<body>
  <header>
    <div class="logo">
      <a href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo"  class="h-8" style="height: 85px;">
      </a>
    </div>
    <div class="user-actions flex items-center space-x-4">
      <span class="welcome-text">Chào, {{ auth()->user()->name }}!</span>
      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="btn-logout">Đăng xuất</button>
      </form>
    </div>
  </header>
  
  <div class="dashboard-container">
    <div class="sidebar">
      <h2 class="text-xl font-semibold mb-4">Menu</h2>
      <ul>
        @if(auth()->user()->role == 'admin')
        <li><a href="{{ route('admin.customers.index') }}" class="hover:bg-gray-700">Quản lý khách hàng</a></li>
        <li><a href="{{ route('admin.employees.index') }}" class="hover:bg-gray-700">Quản lý nhân viên</a></li>
          <li><a href="{{ route('admin.contracts.index') }}" class="hover:bg-gray-700">Quản lý hợp đồng</a></li>
          <li><a href="{{ route('admin.services.index') }}" class="hover:bg-gray-700">Quản lý dịch vụ</a></li>
          <li><a href="{{ route('admin.payments.index') }}" class="hover:bg-gray-700">Quản lý thanh toán</a></li>
          <li><a href="{{ route('admin.reports.index') }}" class="hover:bg-gray-700">Báo cáo thống kê</a></li>
        @elseif(auth()->user()->role == 'employee')
          <li><a href="{{ route('admin.contracts.index') }}" class="hover:bg-gray-700">Quản lý hợp đồng</a></li>
          <li><a href="{{ route('admin.services.index') }}" class="hover:bg-gray-700">Quản lý dịch vụ</a></li>
          <li><a href="" class="hover:bg-gray-700">Quản lý thông tin cá nhân</a></li>
        @endif
      </ul>
    </div>
    <div class="content">
      @yield('content')
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('scripts')
</body>
</html>