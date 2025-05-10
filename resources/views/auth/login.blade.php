<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-[#667eea] from-indigo-500 via-purple- to-pink-500">

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md animate-fadeIn">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng nhập</h1>
    {{-- Hiển thị lỗi --}}
    @if($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
        @foreach($errors->all() as $error)
          <p class="text-sm">{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          value="{{ old('email') ?? request()->cookie('remember_email') }}"
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        >
      </div>

      <!-- Password + Show/hide -->
      <div>
        <label for="password" class="block text-gray-600 font-medium mb-1">Mật khẩu</label>
        <div class="relative">
          <input
            type="password"
            id="password"
            name="password"
            required
            value="{{ request()->cookie('remember_password') }}"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
          >
         
        </div>
      </div>

      <!-- Remember -->
      <div class="flex items-center">
        <input
          type="checkbox"
          name="remember_credentials"
          id="remember_credentials"
          {{ request()->cookie('remember_email') ? 'checked' : '' }}
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
        >
        <label for="remember_credentials" class="ml-2 text-sm text-gray-600">Ghi nhớ đăng nhập</label>
      </div>

      <!-- Submit -->
      <button
        type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition duration-200"
      >
        Đăng nhập
      </button>
    </form>

    <!-- Links -->
    <p class="mt-4 text-center text-sm text-gray-600">
      Chưa có tài khoản?
      <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Đăng ký ngay</a>
    </p>
    <p class="mt-2 text-center">
      <a href="{{ route('password.request') }}" class="text-sm text-indigo-500 hover:underline">Quên mật khẩu?</a>
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

  

</body>
</html>
