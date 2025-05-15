<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-3xl animate-fadeIn">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng ký tài khoản</h1>

    @if($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
        @foreach($errors->all() as $error)
          <p class="text-sm">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Grid 2 cột -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tên -->
        <div>
          <label for="name" class="block text-gray-600 font-medium mb-1">Họ và tên</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Phạm Quang Ngà"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="abc@gmail.com"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Căn cước -->
        <div>
          <label for="identity_card" class="block text-gray-600 font-medium mb-1">CCCD</label>
          <input type="text" id="identity_card" name="identity_card" value="{{ old('identity_card') }}" required maxlength="12"
            placeholder="012345678912"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Năm sinh -->
        <div>
          <label for="dob" class="block text-gray-600 font-medium mb-1">Năm sinh</label>
          <input type="text" id="dob" name="dob" value="{{ old('dob') }}" required maxlength="10" placeholder="dd/mm/yyyy"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Số điện thoại -->
        <div>
          <label for="phone" class="block text-gray-600 font-medium mb-1">SĐT</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="0987654321"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Địa chỉ -->
        <div>
          <label for="address" class="block text-gray-600 font-medium mb-1">Địa chỉ</label>
          <input type="text" id="address" name="address" value="{{ old('address') }}" required placeholder="Số nhà, Đường, Phường, Quận, TP"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Tên công ty -->
        <div>
          <label for="company_name" class="block text-gray-600 font-medium mb-1">Tên công ty(Có thể dùng tên cá nhân)</label>
          <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required placeholder="Công ty TNHH ABC"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <!-- Mã số thuế -->
        <div>
          <label for="tax_code" class="block text-gray-600 font-medium mb-1">Mã số thuế</label>
          <input type="text" id="tax_code" name="tax_code" value="{{ old('tax_code') }}" required placeholder="1234567890"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>
      </div>

     <!-- Mật khẩu -->
<div class="relative">
  <label for="password" class="block text-gray-600 font-medium mb-1">Mật khẩu</label>
  <input type="password" id="password" name="password" required placeholder="********"
  autocomplete="new-password"
  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10">

  <span class="absolute right-3 top-[38px] text-gray-500 cursor-pointer toggle-password" data-target="password">
    <i class="fas fa-eye"></i>
  </span>
</div>

<!-- Xác nhận mật khẩu -->
<div class="relative">
  <label for="password_confirmation" class="block text-gray-600 font-medium mb-1">Xác nhận mật khẩu</label>
  <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="********"
    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10">
  <span class="absolute right-3 top-[38px] text-gray-500 cursor-pointer toggle-password" data-target="password_confirmation">
    <i class="fas fa-eye"></i>
  </span>
</div>
      <!-- Submit -->
      <button type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
        Đăng ký
      </button>

      <p class="mt-4 text-center text-sm text-gray-600">
        Đã có tài khoản?
        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Đăng nhập ngay</a>
      </p>
    </form>
  </div>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.5s ease-in-out;
    }
    input[type="password"]::-ms-reveal,
  input[type="password"]::-ms-clear,
  input[type="password"]::-webkit-credentials-auto-fill-button,
  input[type="password"]::-webkit-clear-button {
    display: none;
  }
  </style>

  <!-- Auto format ngày sinh dd/mm/yyyy -->
  <script>
    document.getElementById('dob').addEventListener('input', function (e) {
      let input = e.target.value.replace(/\D/g, '').substring(0, 8);
      let formatted = '';
      if (input.length > 4) {
        formatted = input.substring(0, 2) + '/' + input.substring(2, 4) + '/' + input.substring(4, 8);
      } else if (input.length > 2) {
        formatted = input.substring(0, 2) + '/' + input.substring(2);
      } else {
        formatted = input;
      }
      e.target.value = formatted;
    });
      document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
    eyeIcon.addEventListener('click', function () {
      const inputId = this.getAttribute('data-target');
      const input = document.getElementById(inputId);
      const icon = this.querySelector('i');

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  });
  </script>
</body>
</html>
