<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Dashboard Admin')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  @stack('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, html { font-family: 'Roboto', sans-serif; background: #f4f7f9; color: #333; }
    header { background: #4a76a8; padding: 1rem 2rem; color: #fff; display: flex; justify-content: space-between; align-items: center; }
    .dashboard-container { display: flex; min-height: calc(100vh - 70px); }
    .sidebar { width: 250px; background: #2d3748; color: #fff; padding: 1.5rem 1rem; }
    .sidebar a { color: #cbd5e0; text-decoration: none; display: block; padding: 0.6rem; border-radius: 4px; transition: background 0.3s; }
    .sidebar a:hover { background: #4a5568; color: #fff; }
    .content { flex: 1; padding: 2rem; background: #fff; overflow-y: auto; }
  </style>
</head>
<body>
  <header>
    <div class="logo"><a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a></div>
    <div class="user-actions">
      <span class="welcome-text">Chào, {{ auth()->user()->name }}!</span>
      <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-danger">Đăng xuất</button></form>
    </div>
  </header>
  
  <div class="dashboard-container">
    <div class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><a href="#">Quản lý khách hàng &amp; nhân viên</a></li>
        <li><a href="{{ route('contracts.index') }}">Quản lý hợp đồng</a></li>
        <li><a href="{{ route('services.index') }}">Quản lý dịch vụ</a></li>
        @if(auth()->user()->role === 'admin')
          <li><a href="#">Quản lý thanh toán</a></li>
          <li><a href="#">Báo cáo thống kê</a></li>
        @endif
        <li><a href="#">Cài đặt tài khoản</a></li>
      </ul>
    </div>
    <div class="content">
      @yield('content')
    </div>
  </div>
  
  @stack('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
