<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-[#667eea] from-indigo-500 via-purple- to-pink-500">

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md animate-fadeIn">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng ký</h1>

    {{-- Hiển thị lỗi --}}
    @if($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
        @foreach($errors->all() as $error)
          <p class="text-sm">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Tên -->
      <div>
        <label for="name" class="block text-gray-600 font-medium mb-1">Tên</label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          required placeholder="Nhập tên của bạn"
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        >
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          required placeholder="Nhập email"
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        >
      </div>
      <!-- Số điện thoại -->
      <div class="mb-4">
        <label for="phone" class="block text-gray-600 font-medium mb-1">Số điện thoại</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại" required 
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
      </div>

      <!-- Địa chỉ -->
      <div class="mb-4">
        <label for="address" class="block text-gray-600 font-medium mb-1">Địa chỉ</label>
        <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Nhập địa chỉ của bạn" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
      </div>
      <!-- Mật khẩu + Hiển thị ẩn -->
      <div>
        <label for="password" class="block text-gray-600 font-medium mb-1">Mật khẩu</label>
        <div class="relative">
          <input
            type="password"
            id="password"
            name="password"
            required placeholder="Nhập mật khẩu"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
          >
          <span class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-indigo-600"
                onclick="togglePassword()">
            <i id="eyeIcon" class="fas fa-eye"></i>
          </span>
        </div>
      </div>

      <!-- Xác nhận mật khẩu + Hiển thị ẩn -->
      <div>
        <label for="password_confirmation" class="block text-gray-600 font-medium mb-1">Xác nhận mật khẩu</label>
        <div class="relative">
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required placeholder="Nhập lại mật khẩu"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
          >
          <span class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-indigo-600"
                onclick="togglePasswordConfirmation()">
            <i id="eyeIconConfirm" class="fas fa-eye"></i>
          </span>
        </div>
      </div>
      <div class="mb-4">
        <label for="company_name" class="block text-gray-600 font-medium mb-1">Tên công ty</label>
        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Nhập tên công ty" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-non">
      </div>

      <div class="mb-4">
        <label for="tax_code" class="block text-gray-700 text-sm font-semibold">Mã số thuế</label>
        <input type="text" id="tax_code" name="tax_code" value="{{ old('tax_code') }}" placeholder="Nhập mã số thuế" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-non">
      </div>
      <!-- Submit -->
      <button
        type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200"
      >
        Đăng ký
      </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
      Đã có tài khoản?
      <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Đăng nhập ngay</a>
    </p>
  </div>

  <!-- Tailwind animation -->
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.5s ease-in-out;
    }
  </style>

  <!-- JS hiện/ẩn mật khẩu -->
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    }

    function togglePasswordConfirmation() {
      const passwordConfirmInput = document.getElementById('password_confirmation');
      const eyeIconConfirm = document.getElementById('eyeIconConfirm');
      const isPasswordConfirm = passwordConfirmInput.type === 'password';
      passwordConfirmInput.type = isPasswordConfirm ? 'text' : 'password';
      eyeIconConfirm.classList.toggle('fa-eye');
      eyeIconConfirm.classList.toggle('fa-eye-slash');
    }
  </script>

</body>
</html>
